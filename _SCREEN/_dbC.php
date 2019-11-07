<?php
class dbC
{

    public $db;
    public $reader;
    public function connect($dn = DB_DB)
    {
        if (!$this->db = new mysqli(DB_HOST, DB_USER, DB_PASS, $dn, DB_PORT))
            if (mysqli_connect_errno())
                return false;
        $this->db->set_charset('utf8');
        return true;
    }

    function readAll()
    {/* bu bulunan tüm tabloyu tablo dizisi olarak döndürür. */

        return $this->reader->fetch_all(MYSQLI_ASSOC);
    }

    function readAllGroup($keyname)
    {/* bir keye göre verileri o key değerine göre gruplar. */
        $result = array();
        while ($row = $this->reader->fetch_assoc())
            $result[$row[$keyname]] = $row;
        return $result;
    }

    function readAllDic($keyname, $keyvalue)
    { /* read type 200 */
        $result = array();

        while ($row = $this->reader->fetch_assoc())
            $result[$row[$keyname]] = $row[$keyvalue];

        return $result;
    }

     function readGroup2Dic($grby, $lv2, $tparams)
    { /* tablo yu iki seviye gruplayıp son seviyede deki değerleri seçer */
        $result = array();
        $tmp = array();
        while ($row = $this->reader->fetch_assoc()) {
            foreach ($tparams as $t)
                $tmp[$t] = $row[$t];
            $result[$row[$grby]][$row[$lv2]] = $tmp;
        }
        return $result;
    }

    public function getLastId()
    {
      return $this->db->insert_id; 
    }

    public function execQuery($sql, $type = null,$q = null, $k = null, $v = null, $a = null)
    {
        if (is_array($q))
            foreach ($q as $k => $v)
                $q[$k] = $this->db->escape_string($v);

           // echo    vsprintf($sql, $q);
        try {
            if ($this->reader = $this->db->query(vsprintf($sql, $q))) {
                switch ($type) {
                    case 1:
                        $r = $this->reader->fetch_assoc();
                        break;
                    case 2:
                        $r = $this->readAll();
                        break;
                    case 3:
                        $r = $this->readAllDic($k, $v);
                        break;
                    case 4:
                        $r = $this->readAllGroup($k);
                        break;
                    case 5:
                        $r = $this->readGroup2Dic($k, $v, $a);
                        break;
                    case 6:
                        $r = $this->reader->fetch_row()[0]; //last insert id // first column first value 
                        break;
                    default:
                        $r = $this->db->affected_rows;
                        break;
                } //switch
                return $r;
            } else //if query
                return -1;
        } catch (Exception $exc) {
            return -2;
        }
    }

    public  function execMultiQuery($q, $typer = false, $k = null, $v = null, $a = null)
    { //çoklu sorgu yapılabilir method sonuçtipini array olarak alır. geriye sorgu srasına göre sonuç dizisi verir.
        $i = 0;

        if ($this->db->multi_query($q)) {
            $result = array();
            do {
                try {
                    if ($this->reader = $this->db->use_result()) {

                        switch ($typer[$i]) { //sonuç tipleri
                            case 1:
                                $r = $this->reader->fetch_assoc();
                                break;
                            case 2:
                                $r = $this->readAll();
                                break;
                            case 3:
                                $r = $this->readAllDic($k, $v);
                                break;
                            case 4:
                                $r = $this->readAllGroup($k);
                                break;
                            case 5:
                                $r = $this->readGroup2Dic($k, $v, $a);
                                break;
                            case 6:
                                $r = $this->reader->fetch_row()[0];
                                break;
                            default:
                                $r = $this->db->affected_rows;
                                break;
                        }

                        $result[$i] = $r;
                        $this->reader->free();
                    }
                } catch (Exception $exc) { }
                $i++;
            } while ($this->db->more_results() && $this->db->next_result());
        }

        return $result;
    }

    public function getScreens($f,$path)
    {
      return $this->execQuery("SELECT sc.*,  COUNT(sp.id) AS spcount FROM screens sc
      LEFT JOIN screen_pages sp ON sp.sid=sc.id 
      WHERE sc.authpath LIKE '%s%%'
	  GROUP BY sc.id
      ORDER BY sc.time DESC;",
      2,array($path)); 
    }

    public function getPages($f,$path)
    {
      return $this->execQuery("SELECT sp.*,  sc.id AS sid, sc.name AS sname FROM screen_pages sp
      LEFT JOIN screens sc ON sp.sid=sc.id 
      WHERE sc.id='%s' AND sc.authpath LIKE '%s%%'
	  ;",
      2,array($f,$path)); 
    }
}
