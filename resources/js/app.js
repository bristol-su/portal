class Form {
    notify(notify) {
        alert(notify);
    }
}

let form = new Form;

form.notify(
    [1,2,3].reduce((prev, n) => prev += n + ', ', '')
);
