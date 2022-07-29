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
                    for (const propName in data) {
                        const propValue = data[propName];
                        
                        let li = document.createElement('li'),
                            spanPropName = document.createElement('span'),
                            spanPropValue = document.createElement('span');

                        spanPropName.className = 'api-data-manager--property-name';
                        spanPropName.innerText = propName;

                        spanPropValue.className = 'api-data-manager--property-value';
                        spanPropValue.innerText = propValue;

                        li.append(spanPropName);
                        li.append(spanPropValue);
                        resUl.append(li);
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