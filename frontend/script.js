let selectCities = new Vue({
    el: '#select_cities',
    data: {
        urlReceive: 'http://b-apis/api',
        cities: [],
        cityWeather: [],
        gotWeather: false,
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
                    id: city.city_name_en,
                    name: city.city_name_en
                })
            });
        },
        parseWeather: function(weather) {
            const current = weather.current

            let period = new Map();
            period.set(0, 'ночь');
            period.set(1, 'день');

            let windDir = new Map();
            windDir.set('S', 'южный');
            windDir.set('SW', 'юго-западный');
            windDir.set('SE', 'юго-восточный');
            windDir.set('N', 'северный');
            windDir.set('NW', 'северо-западный');
            windDir.set('NE', 'северо-восточный');

            this.cityWeather = [{
                city: weather.location.name,
                icon: current.condition.icon,
                temp_c: current.temp_c,
                gust_kph: 15.5, // порывы ветра
                humidity: current.humidity, // влажность
                is_day: period.get(current.is_day),
                wind_dir: windDir.get(current.wind_dir),
                wind_kph: current.wind_kph,
                cloud: current.cloud,
                last_updated: current.last_updated,
            }];
            console.log('weather:');
            console.log(weather);
        },
        retrieveCityData: function(e) {
            const cityName = e.target.value.replace(' ', '%20');
            const url = 'https://weatherapi-com.p.rapidapi.com/current.json?q=' + cityName

            const headers = {
                'X-RapidAPI-Key': '371ef07306msh4c6de730e39801dp1616ccjsn600fb9f97d16',
                'X-RapidAPI-Host': 'weatherapi-com.p.rapidapi.com',
            }

            fetch(url, {
                    method: 'GET',
                    headers: headers,
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
        generateResultJson: function(e) {
            let xhr = new XMLHttpRequest();
            let url = this.urlSend + '/result/';
            xhr.open('POST', url, true);
            xhr.setRequestHeader('Content-Type', 'application/json');
            // xhr.setRequestHeader('Origin', 'http://f-apis/');
            // xhr.setRequestHeader('Content-Length', '0');
            // xhr.setRequestHeader('Accept', '/');
            // xhr.setRequestHeader('Accept-Encoding', 'gzip, deflate, br');
            // xhr.setRequestHeader('Connection', 'keep-alive');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    console.log(this.responseText);
                }
            };
            xhr.send('blabla');
        }
    }
})