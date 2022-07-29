let selectCities = new Vue({
    el: '#select_cities',
    data: {
        urlReceive: 'http://b-apis/api',
        cities: [],
        cityWeather: [],
        cityId: 0,
        jsonLink: ''
    },
    mounted: function() {
        this.getCities();
    },
    methods: {
        getCities: function() {
            const url = this.urlReceive + '/cities';

            fetch(url).then((response) => {
                    return response.json()
                })
                .then((data) => {
                    this.parseCities(data)
                })
                .catch((error) => {
                    console.log(error)
                })
        },
        getCityData: function(e) {
            this.cityId = e.target.attributes.city_id.value;

            const url = 'http://b-apis/api/city/' + this.cityId + '/weather';

            fetch(url, {
                    method: 'GET',
                }).then((response) => {
                    return response.json()
                })
                .then((data) => {
                    this.parseWeather(data)
                })
                .catch((err) => {
                    console.error(err)
                })
        },
        parseCities: function(cities) {
            cities.forEach(city => {
                this.cities.push({
                    name: city.city_name_en,
                    city_id: city.id
                })
            });
        },
        parseWeather: function(weather) {
            const current = weather;

            let period = new Map();
            period.set(0, 'night');
            period.set(1, 'day');

            let windDir = new Map();
            windDir.set('S', 'south');
            windDir.set('SW', 'south-west');
            windDir.set('SE', 'south-east');
            windDir.set('ESE', 'east-south-east');
            windDir.set('N', 'north');
            windDir.set('NW', 'north-west');
            windDir.set('NE', 'north-east');

            this.cityWeather = [{
                city: current.city_name_en,
                icon: current.icon_file,
                temp_c: current.temp_c,
                humidity: current.humidity_p,
                is_day: period.get(current.is_day),
                wind_dir: windDir.get(current.wind_dir),
                wind_kph: current.wind_kph,
                cloud: current.cloud_p,
                last_updated: current.updated_at,
            }];
        },
        sendCityIdToCreateJson: function() {
            const url = 'http://b-apis/api/city/' + this.cityId + '/json';

            fetch(url, {
                    method: 'GET',
                }).then((response) => {
                    return response.json();
                })
                .then((data) => {
                    this.jsonLink = 'http://b-apis' + data.link;
                })
                .catch((err) => {
                    console.error(err);
                })
        }
    }
});
