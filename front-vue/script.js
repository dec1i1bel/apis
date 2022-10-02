let selectCities = new Vue({
    el: '#select_cities',
    data: {
        urlLar: 'http://apis-back-lar',
        urlSymf: 'http://apis-back-symf',
        urlReceiveLar: '',
        urlReceiveSymf: '',
        cities: [],
        cityWeather: [],
        cityPlaces: [],
        cityId: 0,
        placesPhotos: new Map(),
        jsonLink: ''
    },
    mounted: function () {
        this.urlReceiveLar = this.urlLar + '/api';
        this.urlReceiveSymf = this.urlSymf + '/api';
        this.getCities();
    },
    methods: {
        getCities: function () {
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
        parseCities: function (cities) {
            cities.forEach(city => {
                this.cities.push({
                    name: city.city_name_en,
                    city_id: city.id,
                    latitude: city.latitude,
                    longitude: city.longitude
                })
            });
        },
        getCityData: function (e) {
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
        parseWeather: function (weather) {
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
        parsePlaces: function (places) {
            var placeData, placePhotos;

            places[this.cityId].forEach(place => {
                placeData = new Map();
                placeData.set('id', place.id);
                placeData.set('name', place.name);
                placeData.set('latitude', place.latitude);
                placeData.set('longitude', place.longitude);
                placeData.set('htmlId', 'place-details-' + place.id);
                placeData.set('htmlMapId', 'place-map-' + place.id);
                placeData.set('htmlHref', '#place-details-' + place.id);

                this.cityPlaces.push(placeData);
            });
            console.log('this.cityPlaces');
            console.log(this.cityPlaces);
            this.getPlacesPhotos();
            this.getPlacesMaps();
        },
        getPlacesPhotos: function () {
            const places = this.cityPlaces,
                urlReceiveLar = this.urlReceiveLar;

            let placesPhotos = this.placesPhotos,
                thisPhotos = [];

            $('#places_details').ready(function () {
                for (const place of places) {

                    // toDo: если для place не пришли фото - по нему отправлять повторный запрос
                    // toDo: почитать о Reactivity в Vue https://v2.vuejs.org/v2/guide/reactivity.html (по ошибке при рендере фоток)

                    const placeId = place.get('id');
                    const url = urlReceiveLar + '/place/' + placeId + '/photos';

                    fetch(url, {
                        method: 'GET',
                        }).then(response => {
                            return response.json()
                        })
                        .then(photos => {
                            thisPhotos = [];
                            photos.forEach(function (el) {
                                thisPhotos.push(el)
                            });
                            placesPhotos.set(placeId, thisPhotos);
                        })
                        .catch(err => {
                            console.error(err)
                        })
                }
                this.placesPhotos = placesPhotos;
                console.log('this.placesPhotos');
                console.log(this.placesPhotos);
                console.log('this.cityPlaces');
                console.log(this.cityPlaces);
            });
        },
        getPlacesMaps: function () {
            const places = this.cityPlaces;

            $('#places_details').ready(function () {
                ymaps.ready(function () {
                    for (const place of places) {
                        const lat = place.get('latitude'),
                            lng = place.get('longitude');
                        const placeGeoObj = new ymaps.GeoObject({
                            geometry: {
                                type: "Point",
                                coordinates: [lat, lng]
                            }
                        });
                        let placeMap = new ymaps.Map(place.get('htmlMapId'), {
                            center: [lat, lng],
                            zoom: 10
                        });
                        placeMap.geoObjects.add(placeGeoObj)
                    }
                });
            });

            $('#places-buttons').ready(function () {
                $('#places-buttons .js-place-button').click(function (e) {
                    const placeId = $(this).attr('aria-controls');
                    $('#places-details .js-map-collapse').removeClass('show');
                    $('#' + placeId).addClass('show');
                });
            });
        },
        sendCityIdToCreateJson: function () {
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
