var app = new Vue({
    el: '#app',
    data: {
        id : '',
        name: '',
        items: [],
        hasError: false
    },
    methods: {
        addUrl: function () {
            var url = 'https://www.hltv.org/stats/teams/' + this.id + '/' + this.name;

            if (this.id.length === 0) {
                alert('Заполните поле id');
                return;
            }

            if (this.name.length === 0) {
                alert('Заполните поле name');
                return;
            }

            if (this.items.indexOf(url) !== -1) {
                this.id = '';
                this.name = '';
                return;
            }

            var config = {
                headers: {
                    'Content-Type' : 'application/json',
                    'Cache-Control': 'no-cache'
                }
            };

            axios.post('/urls/create', {
                    url: url
                }, config).then(function (response) {
                    app.items.push(url);
                    app.hasError = false;
                    app.id = '';
                    app.name = '';
                })
                .catch(function (error) {
                    app.hasError = true;
                });
        }
    }
});