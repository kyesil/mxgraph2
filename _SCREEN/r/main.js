var app = new Vue({
    el: '#app',
    data: {
        screens: [],
        pages: [],
        vpage:"screens",
        vtitle:""
    },
    mounted() {

        loadScreens();
    },
    methods: {
        scCardClick: function (id,name) {
            loadPages(id,name)
        },
        pgCardClick:function pgCardClick(id,name) {
            alert(id);
        }
      }
})



function backClick(param) {
app.vpage="main"
app.vtitle="Screens";
}

function addClick(param,name) {
    app.vpage="add"
    if (param)  app.vtitle="Edit <b>"+name+"</b>"; else  app.vtitle="Add";
    }

function loadScreens(param) {
    fetch('_dbaction.php?action=getsclist&param=' + param)
        .then(res => res.json())
        .then(json => {
            app.vpage="main";
            app.vtitle="Screens";
            if (json.data)
                app.screens = json.data;
            console.log(json);
        })
        .catch(error => {
            console.log('Error Load Screen Request', error)
        });
}

function loadPages(param,name) {
    fetch('_dbaction.php?action=getsplist&param=' + param)
        .then(res => res.json())
        .then(json => {
            app.vpage="pages";
            app.vtitle="Pages for <b>"+name+"</b>";
            if (json.data)
                app.pages = json.data;
            console.log(json);
        })
        .catch(error => {
            console.log('Error Load Page Request', error)
        });
}