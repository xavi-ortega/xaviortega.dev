export class Form {
    constructor(form) {
        this.form = document.getElementById(form);
        this.fields = {};
        this.rules = {};
    }

    addField(fieldName, value = '') {
        this.fields[fieldName] = value;
    }

    addRule(fieldName, rule) {
        this.rules[fieldName] = rule;
    }

    isValid() {
        this.fetchValues();

        return Object.keys(this.rules).every(fieldName => {
            if(this.fields[fieldName]) {
                return this.rules[fieldName](this.fields[fieldName]);
            } else {
                return this.rules[fieldName]();
            }
        });
    }

    getErrors() {
        return Object.keys(this.rules).map(fieldName => {
            if(this.fields[fieldName]) {
                if(!this.rules[fieldName](this.fields[fieldName])) {
                    return fieldName;
                }
            } else {
                console.log(fieldName);
                if(!this.rules[fieldName]()) {
                    return fieldName;
                }
            }
        }, []);
    }

    onSubmit(callback) {
        document.removeEventListener('submit', this.form);

        this.form.addEventListener('submit', (e) => {
            e.preventDefault();

            this.fetchValues();

            callback(this.fields);
        });
    }


    fetchValues() {
        this.fields = Object.keys(this.fields).reduce((fields, fieldName) => {
            fields[fieldName] = document.querySelector(`.form-control[name='${fieldName}']`).value;
            return fields;
        }, {});
    }

    reset() {
        Object.keys(this.fields).forEach(fieldName => {
            document.querySelector(`.form-control[name=${fieldName}]`).value = '';
        })
    }
}
