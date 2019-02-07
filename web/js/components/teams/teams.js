Vue.component('players-list', {
    props: ['team_id'],
    data: function () {
        return {
            items: []
        }
    },
    mounted: function () {
        var tobj = this;
        axios.get('/players/index?search&team_id=' + this.team_id).then(function (response) {
            tobj.items = response.data;
        }).catch(function (error) {
            alert('request error');
        });
    },
    template: '#players-list-template'
});

var app = new Vue({
    el: '#app',
    data: {
        url : '',
        items: [],
        showPlayersFlags: []
    },
    methods: {
        showPlayers: function (id) {
            var index = app.showPlayersFlags.indexOf(id);
            if (index === -1) {
                app.showPlayersFlags.push(id);
            } else {
                app.showPlayersFlags.splice(index, 1);
            }
        }
    },
    mounted: function () {
        axios.get('/teams/index', {

        }).then(function (response) {
            app.items = response.data;
            app.items.forEach(function(element) {

            });
        }).catch(function (error) {
            alert('request error');
        });
    }
});