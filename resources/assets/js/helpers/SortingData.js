export class SortingData {
    constructor() {
        this.SortingStyle = true;
    }

    sortSupervisionData(list, sortKey, sortNumbers) {
        if (sortNumbers) {
            return this.sortNumbersData(list, sortKey);
        }
        if (this.SortingStyle) {
            list.sort(function (a, b) {
                if (a['' + sortKey + ''] < b['' + sortKey + '']) {
                    return 1;
                }
                if (a['' + sortKey + ''] > b['' + sortKey + '']) {
                    return -1;
                }
                return 0;
            });
            this.SortingStyle = !this.SortingStyle;
        } else {
            list.sort(function (a, b) {
                if (a['' + sortKey + ''] > b['' + sortKey + '']) {
                    return 1;
                }
                if (a['' + sortKey + ''] < b['' + sortKey + '']) {
                    return -1;
                }
                return 0;
            });
            this.SortingStyle = !this.SortingStyle;
        }
        return list;
    }

    //Sorting data with string to float
    sortNumbersData(list, sortKey) {
        if (this.SortingStyle) {
            list.sort(function (a, b) {
                if (parseFloat(a['' + sortKey + '']) < parseFloat(b['' + sortKey + ''])) {
                    return 1;
                }
                if (parseFloat(a['' + sortKey + '']) > parseFloat(b['' + sortKey + ''])) {
                    return -1;
                }
                return 0;
            });
            this.SortingStyle = !this.SortingStyle;
        } else {
            list.sort(function (a, b) {
                if (parseFloat(a['' + sortKey + '']) > parseFloat(b['' + sortKey + ''])) {
                    return 1;
                }
                if (parseFloat(a['' + sortKey + '']) < parseFloat(b['' + sortKey + ''])) {
                    return -1;
                }
                return 0;
            });
            this.SortingStyle = !this.SortingStyle;
        }
        return list;
    }

//    sorting data with inner property "supervision.name"
    sortSupervisionByName(list) {
        if (this.SortingStyle) {
            list.sort(function (a, b) {
                if ((a.supervision.name) < (b.supervision.name)) {
                    return 1;
                }
                if ((a.supervision.name) > (b.supervision.name)) {
                    return -1;
                }
                return 0;
            });
            this.SortingStyle = !this.SortingStyle;
        } else {
            list.sort(function (a, b) {
                if ((a.supervision.name) > (b.supervision.name)) {
                    return 1;
                }
                if ((a.supervision.name) < (b.supervision.name)) {
                    return -1;
                }
                return 0;
            });
            this.SortingStyle = !this.SortingStyle;
        }
        return list;
    }

    //sort Data to Mine supervisor list
    sortMineSupervisionData(list, sortKey,) {
        list.sort(function (a, b) {
            if (a['' + sortKey + ''] < b['' + sortKey + '']) {
                return 1;
            }
            if (a['' + sortKey + ''] > b['' + sortKey + '']) {
                return -1;
            }
            return 0;
        });
        return list;
    }

    //    sorting data in RegisteringSupervision page
    sortSupervisionByNameRegistering(list) {
        if (this.SortingStyle) {
            list.sort(function (a, b) {
                var nameA;
                var nameB
                //check if object has property supervisor from role selfRegister supervisor,
                //if not check data from role Supervisor( user table)
                if (typeof(a.supervision) !== 'undefined'){
                     nameA = a.supervision.name;
                }else{
                    nameA = a.user.name;
                }
                if (typeof(b.supervision) !== 'undefined'){
                     nameB = b.supervision.name;
                }
                else{
                    nameB = b.user.name;
                }


                if ((nameA) < (nameB)) {
                    return 1;
                }
                if ((nameA) > (nameB)) {
                    return -1;
                }
                return 0;
            });
            this.SortingStyle = !this.SortingStyle;
        } else {
            list.sort(function (a, b) {
                var nameA;
                var nameB
                //check if object has property supervisor from role selfRegister supervisor,
                //if not check data from role Supervisor( user table)
                if (typeof(a.supervision) !== 'undefined'){
                    nameA = a.supervision.name;
                }else{
                    nameA = a.user.name;
                }
                if (typeof(b.supervision) !== 'undefined'){
                    nameB = b.supervision.name;
                }
                else{
                    nameB = b.user.name;
                }
                if ((nameA) > (nameB)) {
                    return 1;
                }
                if ((nameA) < (nameB)) {
                    return -1;
                }
                return 0;
            });
            this.SortingStyle = !this.SortingStyle;
        }
        return list;
    }

}
;
