let selectCities = new Vue({
    el: '#select_cities',
    data: {
        cities: [],
        cityWeather: [],
    },
    mounted: function () {
        this.getCities();
    },
    methods: {
        getCities: function () {
            const url = 'https://wft-geo-db.p.rapidapi.com/v1/geo/cities?minPopulation=20000000'

            const headers = {
                'X-RapidAPI-Host': 'wft-geo-db.p.rapidapi.com',
                'X-RapidAPI-Key': '371ef07306msh4c6de730e39801dp1616ccjsn600fb9f97d16'
            }

            fetch(url, {
                headers: headers
            }).then((response) => {
                return response.json()
            })
            .then((data) => {
                this.parseCities(data)
            })
            .catch((error) => {
                console.log(error)
            })
        },
        parseCities: function (data) {
            const cities = data.data

            for (const i in cities) {
                const city = cities[i]
                this.cities.push({id: city.wikiDataId, name: city.name})
            }
        },
        parceWeather: function (data) {

        },
        retrieveCityData: function (e) {
            cityId = e.target.value

            const url = 'https://weatherapi-com.p.rapidapi.com/current.json'

            const headers = {
                'X-RapidAPI-Host': 'weatherapi-com.p.rapidapi.com',
                'X-RapidAPI-Key': '371ef07306msh4c6de730e39801dp1616ccjsn600fb9f97d16'
            }

            fetch(url, {
                headers: headers
            }).then((response) => {
                return response.json()
            })
            .then((data) => {
                this.parseWeather(data)
            })
            .catch((error) => {
                console.log(error)
            })
        },
    }
})