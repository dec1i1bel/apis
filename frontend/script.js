let selectCities = new Vue({
    el: '#select_cities',
    data: {
        cities: [],
        cityWeather: [],
        gotWeather: false,
    },
    mounted: function () {
        this.getCities();
    },
    methods: {
        getCities: function () {
            const url = 'https://data-boom.ru/api/cities';

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
        parseCities: function (cities) {
            cities.forEach(city => {
                this.cities.push({
                    id: city.city_name_en, 
                    name: city.city_name_en
                })
            });
        },
        parseWeather: function (weather) {
            const current = weather.current
            this.cityWeather = [{
                city: weather.location.name,
                icon: current.condition.icon,
                temp_c: current.temp_c,
                gust_kph: 15.5, // порывы ветра
                humidity: current.humidity, // влажность
                is_day: current.is_day,
                wind_dir: current.wind_dir,
                wind_kph: current.wind_kph,
                cloud: current.cloud,
                last_updated: current.last_updated,
            }]
            console.log(weather)
        },
        retrieveCityData: function (e) {
            cityName = e.target.value
            console.log('cityName');
            console.log(cityName);

            // const url = 'https://weather338.p.rapidapi.com/locations/search?query=Los%20Angeles&language=en-US'
            
            const url = 'https://weatherapi-com.p.rapidapi.com/current.json?q=Los%20Angeles'

            const headers = {
                'X-RapidAPI-Key': '371ef07306msh4c6de730e39801dp1616ccjsn600fb9f97d16',
                // 'X-RapidAPI-Host': 'weather338.p.rapidapi.com',
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
    }
})