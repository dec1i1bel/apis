class ApiDataManager {

    divId = '';
    jsonUrl = '';

    constructor(divId, jsonUrl) {
        this.divId = divId;
        this.jsonUrl = jsonUrl;
    }

    getData() {
        let main = document.querySelector('#' + this.divId);

        fetch(this.jsonUrl)
            .then(response => {
                return response.json();
            })
            .then(data => {
                let resUl = document.createElement('ul');
                    resUl.className = 'api-data-manager--container';
                let liExt, liIneer1, liIneer2, li, ulExt, ulInner;
                    for (const propExternal in data) {
                        const propExtValue = data[propExternal];
                        console.log('propExternal');
                        console.log([
                            propExternal,
                            propExtValue
                        ]);
                        liExt = document.createElement('li');
                            liExt.innerText = propExternal + ': ';
                            liExt.append(resUl);

                            liIneer1 = document.createElement('li');
                            ulExt = document.createElement('ul');

                            for (const propInner in propExtValue) {
                                const propInnerValue = propExtValue[propInner];
                                console.log('propInner');
                                console.log([
                                    propInner,
                                    propInnerValue
                                ]);
                                liIneer2 = document.createElement('li');
                                liIneer2.innerText = propInner + ': ';
                                liIneer2.append(ulExt);

                                ulInner = document.createElement('ul');

                                for (const propData in propInnerValue) {
                                    const data = propInnerValue[propData];
                                    console.log('propData');
                                    console.log([
                                        propData,
                                        data
                                    ]);
                                    li = document.createElement('li');
                                    li.innerText = propData + ': ' + data;
                                    li.append(ulInner);
                                }
                                ulInner.append(ulExt);
                            }
                            ulExt.append(resUl);

                        // let li = document.createElement('li'),
                        //     spanPropName = document.createElement('span'),
                        //     spanPropValue = document.createElement('span');
                        //
                        // spanPropName.className = 'api-data-manager--property-name';
                        // spanPropName.innerText = propName;
                        //
                        // spanPropValue.className = 'api-data-manager--property-value';
                        // spanPropValue.innerText = propValue;
                        //
                        // li.append(spanPropName);
                        // li.append(spanPropValue);
                        // resUl.append(li);
                    }
                // main.append(resUl);
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