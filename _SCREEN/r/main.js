var app = new Vue({
    el: '#app',
    data: {
        screens: [],
        pages: [],
        vpage: "screens",
        vtitle: "",
        pid: 0
    },
    mounted() {

        loadScreens();
    },
    methods: {
        scOpenClick: function (id, name) {
            loadPages(id, name)
        },
        pgEditClick: function pgCardClick(id, name) {
            alert(id);
        },
        scDrawClick: function (id, name) {
            alert(id);
        },
        pgEditClick: function pgCardClick(id, name) {
            alert(id);
        }
    }
})


function refreshClick() {
    if (app.vpage == "screens") {
        loadScreens();
     }
    else if (app.vpage == "pages") {

        loadPages(app.pid);
    }
}

function backClick(param) {
    app.vpage = "screens"
    app.vtitle = "Screens";
}

function addClick(id) {
    app.vtitle="Add/Edit/Remove";
    if (app.vpage == "screens"){
       if(id) app.dtitle="Edit Screen:"+app.screens[id].name;
       else  app.dtitle="Add Screen";
        app.vpage = "addsc";
    }
    else if (app.vpage == "pages") {
        app.vpage = "addpg";
        if(id) app.dtitle="Edit Page:"+app.pages[id].name + " to "+ app.screens[app.pid].name;
        else  app.dtitle="Add Page to: " + app.screens[app.pid].name;
    }
}

function loadScreens(id) {
    fetch('_dbaction.php?action=getsclist&param=' + id)
        .then(res => res.json())
        .then(json => {
            app.vpage = "screens";
            app.vtitle = "Screens";
            data = {};
            if (json.data) {
                for (const j in json.data)
                    data[json.data[j].id] = json.data[j];
                app.screens = data;
            }
            console.log(data);
        })
        .catch(error => {
            console.log('Error Load Screen Request', error)
        });
}

function loadPages(id) {
    fetch('_dbaction.php?action=getsplist&param=' + id)
        .then(res => res.json())
        .then(json => {
            app.pid = id;
            app.vpage = "pages";
            app.vtitle = "Pages for <b>" + app.screens[id].name + "</b>";
            data = {};
            if (json.data) {
                for (const j in json.data)
                    data[json.data[j].id] = json.data[j];
                app.pages = data;
            }
            console.log(data);
        })
        .catch(error => {
            console.log('Error Load Page Request', error)
        });
}