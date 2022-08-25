class ApiDataManager {

    divId = '';
    jsonUrl = '';

    constructor(divId, jsonUrl) {
        this.divId = divId;
        this.jsonUrl = jsonUrl;
    }

    getData() {
        fetch(this.jsonUrl)
            .then(response => {
                return response.json();
            })
            .then(data => {
                let liExt, liInner2, li, ulExt, ulInner, ulPlaces, liPlaces;
                let main = document.querySelector('#' + this.divId);
                let resUl = document.createElement('ul');

                resUl.className = 'api-data-manager--container';
                main.append(resUl);

                for (const propExternal in data) {
                    const propExtValue = data[propExternal];

                    liExt = document.createElement('li');
                    liExt.innerText = propExternal + ': ';
                    resUl.append(liExt);

                    ulExt = document.createElement('ul');
                    for (const propInner in propExtValue) {
                        const propInnerValue = propExtValue[propInner];

                        liInner2 = document.createElement('li');
                        liInner2.innerText = propInner + ': ';
                        ulExt.append(liInner2);

                        ulInner = document.createElement('ul');
                        for (const propData in propInnerValue) {
                            const data = propInnerValue[propData];

                            if (propInner === 'places') {
                                li = document.createElement('li');
                                li.innerText = propData + ': ';
                                ulInner.append(li);

                                ulPlaces = document.createElement('ul');
                                for (const propPlace in data) {
                                    let placeData = data[propPlace];

                                    liPlaces = document.createElement('li');
                                    liPlaces.innerText = propPlace + ': ' + placeData;
                                    ulPlaces.append(liPlaces);
                                }
                                ulInner.append(ulPlaces);
                            } else {
                                li = document.createElement('li');
                                li.innerText = propData + ': ' + data;
                                ulInner.append(li);
                            }
                        }
                        ulExt.append(ulInner);
                    }
                    resUl.append(ulExt);
                }
                main.append(resUl);
            })
            .catch(err => {
                const errorMessage = 'Error receiving data from json file. ';
                const error = errorMessage + err;

                let result = document.createElement('p');
                result.className = 'api-data-manager--container error-message';
                result.innerText = error;
                main.append(result);
            });
    }
}