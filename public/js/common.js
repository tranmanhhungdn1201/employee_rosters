function arrDataToObject(arr) {
    return arr.reduce((a, b) => {
        let {name, value} = b;
        return {
                ...a,
                [name]: value
            };
    }, {});
}