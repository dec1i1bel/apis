let selectCities = new Vue({
    el: '#select_cities',
    data: {
        urlReceive: 'http://b-apis/api',
        cities: [],
        cityWeather: [],
        cityId: 0,
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
                    console.log('cities:');
                    console.log(data);
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
                    city_id: city.id
                })
            });
        },
        parseWeather: function(weather) {
            const current = weather;

            let period = new Map();
            period.set(0, 'ночь');
            period.set(1, 'день');

            let windDir = new Map();
            windDir.set('S', 'южный');
            windDir.set('SW', 'юго-западный');
            windDir.set('SE', 'юго-восточный');
            windDir.set('ESE', 'восточно-юго-восточный');
            windDir.set('N', 'северный');
            windDir.set('NW', 'северо-западный');
            windDir.set('NE', 'северо-восточный');

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
        }/*,
        sendCityIdToApi: function(e) {
            let xhr = new XMLHttpRequest();
            let url = this.urlSend + this.cityId;
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(this.responseText);
                }
            };
            xhr.send('blabla');
        }*/
    }
})