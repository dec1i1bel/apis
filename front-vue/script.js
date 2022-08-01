let selectCities = new Vue({
    el: '#select_cities',
    data: {
        urlLar: 'http://back-lar-apis',
        urlSymf: 'http://back-symf-apis',
        urlReceiveLar: '',
        urlReceiveSymf: '',
        cities: [],
        cityWeather: [],
        cityPlaces: [],
        cityId: 0,
        jsonLink: ''
    },
    mounted: function() {
        this.urlReceiveLar = this.urlLar + '/api';
        this.urlReceiveSymf = this.urlSymf + '/api';
        this.getCities();
    },
    methods: {
        getCities: function() {
            const url = this.urlReceiveLar + '/cities';

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
        parseCities: function(cities) {
            cities.forEach(city => {
                this.cities.push({
                    name: city.city_name_en,
                    city_id: city.id,
                    latitude: city.latitude,
                    longitude: city.longitude
                })
            });
        },
        getCityData: function(e) {
            this.cityId = e.target.attributes.city_id.value;

            const urlWeather = this.urlReceiveLar + '/city/' + this.cityId + '/weather';

            fetch(urlWeather, {
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

            const urlPlaces = this.urlReceiveSymf + '/city/' + this.cityId + '/places';

            fetch(urlPlaces, {
                method: 'GET',
            }).then((response) => {
                return response.json()
            })
            .then((data) => {
                this.parsePlaces(data)
            })
            .catch((err) => {
                console.error(err)
            })
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
        parsePlaces: function(places) {
            places.forEach(place => {
                this.cityPlaces.push({
                    name: place.place_name_en,
                    latitude: place.latitude,
                    longitude: place.longitude,
                    description: place.description
                });
            })
        },
        sendCityIdToCreateJson: function() {
            const url = this.urlReceiveLar + '/city/' + this.cityId + '/json';

            fetch(url, {
                    method: 'GET',
                }).then((response) => {
                    return response.json();
                })
                .then((data) => {
                    this.jsonLink = this.urlLar + data.link;
                })
                .catch((err) => {
                    console.error(err);
                })
        }
    }
});
