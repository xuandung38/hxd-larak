import _ from 'lodash';

export default {
    convertToLatin(str) {
        str = str.toLowerCase();
        str = str.replace(/à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ/g, "a");
        str = str.replace(/è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ/g, "e");
        str = str.replace(/ì|í|ị|ỉ|ĩ/g, "i");
        str = str.replace(/ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ/g, "o");
        str = str.replace(/ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ/g, "u");
        str = str.replace(/ỳ|ý|ỵ|ỷ|ỹ/g, "y");
        str = str.replace(/đ/g, "d");
        // Some system encode vietnamese combining accent as individual utf-8 characters
        str = str.replace(/\u0300|\u0301|\u0303|\u0309|\u0323/g, "");
        str = str.replace(/\u02C6|\u0306|\u031B/g, ""); // Â, Ê, Ă, Ơ, Ư
        return str;
    },

    buildQueryFromObject(obj) {
        let query = '';

        Object.keys(obj).forEach(key => {
            if (obj[key] !== '') {
                query += query === ''
                    ? '?' + key + '=' + obj[key]
                    : '&' + key + '=' + obj[key];
            }
        });

        return query;
    },

    buildQueryString(obj) {
        let query = '';

        Object.keys(obj).forEach(key => {
            if (obj[key] !== '' && obj[key] !== null) {
                query += query === ''
                    ? '?' + key + '=' + obj[key]
                    : '&' + key + '=' + obj[key];
            }
        });

        return query;
    },

    formatSlug(str) {
        str = str.trim();
        str = this.convertToLatin(str);
        // eslint-disable-next-line no-useless-escape
        str = str.replace(/[&\/\\#^,+()$~%.\-'":*?<>{}]/g, '');
        str = str.replace(/\s/g, '-');

        return str;
    },

    convertJson(str) {
        if (str !== "" && str != null && typeof (str) !== "undefined") {
            try {
                return JSON.parse(str.replace(/&quot;/g, '"'));
            } catch (err) {
                return str;
            }
        } else {
            return null;
        }
    },

    formatMoney(money) {
        if (money === null) {
            return 0;
        }

        return money.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1,');
    },

    strLimit(str, length, ending) {
        if (length == null) {
            length = 100;
        }
        if (ending == null) {
            ending = '...';
        }
        if (str.length > length) {
            return str.substring(0, length - ending.length) + ending;
        } else {
            return str;
        }
    },

    inputMoneyToInt(input) {
        let number = _.clone(input).replace(/[.,"]/g, '');
        return parseInt(number);
    },

    randomColor() {
        const letters = '0123456789ABCDEF';
        let color = '#';
        for (let i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }

        return color;
    },
    removeNullAttribute(data) {
        _.forEach(data, (item, key) => {
            if (item === null) {
                delete data[key];
            }
        });

        return data;
    },
    removeEmptyAttribute(data) {
        _.forEach(data, (item, key) => {
            if (_.isEmpty(item)) {
                delete data[key];
            }
        });

        return data;
    },

    convertBooleanAttribute(data) {
        _.forEach(data, (item, key) => {
            if (item === true) {
                data[key] = 1;
            }
            if (item === false) {
                data[key] = 0;
            }
        });

        return data;
    },

    convertRelativeTime(previous) {
        const current = new Date();
        const msPerMinute = 60 * 1000;
        const msPerHour = msPerMinute * 60;
        const msPerDay = msPerHour * 24;
        const msPerMonth = msPerDay * 30;
        const msPerYear = msPerDay * 365;

        const elapsed = current - previous;

        if (elapsed < msPerMinute) {
            return Math.round(elapsed / 1000) + ' seconds ago';
        } else if (elapsed < msPerHour) {
            return Math.round(elapsed / msPerMinute) + ' minutes ago';
        } else if (elapsed < msPerDay) {
            return Math.round(elapsed / msPerHour) + ' hours ago';
        } else if (elapsed < msPerMonth) {
            return 'approximately ' + Math.round(elapsed / msPerDay) + ' days ago';
        } else if (elapsed < msPerYear) {
            return 'approximately ' + Math.round(elapsed / msPerMonth) + ' months ago';
        } else {
            return 'approximately ' + Math.round(elapsed / msPerYear) + ' years ago';
        }
    },

    getEmbedYoutubeUrl(url) {
        const strArr = url.split('?v=');

        return 'https://www.youtube.com/embed/' + strArr[1] + '?controls=0';
    },

    convertBase64ToBlob(data) {
        const byteString = (data.split(',')[0].indexOf('base64') >= 0)
            ? atob(data.split(',')[1])
            : unescape(data.split(',')[1]);

        // separate out the mime component
        const mimeString = data.split(',')[0].split(':')[1].split(';')[0];

        // write the bytes of the string to a typed array
        let ia = new Uint8Array(byteString.length);
        for (let i = 0; i < byteString.length; i++) {
            ia[i] = byteString.charCodeAt(i);
        }

        return new Blob([ia], {type: mimeString});
    },

    copyToClipboard(str) {
        const el = document.createElement('textarea');
        el.value = str;
        el.setAttribute('readonly', '');
        el.style.position = 'absolute';
        el.style.left = '-9999px';
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
    },

    randomString(length) {
        let result = '';
        let characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        const charactersLength = characters.length;

        for (let i = 0; i < length; i++) {
            result += characters.charAt(Math.floor(Math.random() * charactersLength));
        }

        return result;
    },

    now() {
        const today = new Date();
        const dd = String(today.getDate()).padStart(2, '0');
        const mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        const yyyy = today.getFullYear();

        return yyyy + '/' + mm + '/' + dd;
    },

    getParamFromUrl(param) {
        const url = new URL(window.location.href);
        return url.searchParams.get(param);
    },
    isExist(key, value, array) {
        for (let i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return true;
            }
        }

        return false;
    },
    getItemOfArray(key, value, array) {
        for (let i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return array[i];
            }
        }

        return null;
    },

    getRealCurrencyValue(value, unit) {
        if (unit === 'yen') {
            return Math.round(value / 100)
        }

        return value;
    },

    exchangeArrayItem(arr, oldIndex, newIndex) {
        if (newIndex >= arr.length) {
            let k = newIndex - arr.length + 1;
            while (k--) {
                arr.push(undefined);
            }
        }
        arr.splice(newIndex, 0, arr.splice(oldIndex, 1)[0]);
        return arr;
    },

    getEnumByKey(items, key) {
        for (const item of items) {
            if (item.key === key) {
                return item
            }
        }
        return null
    },
    getEnumByValue(items, value) {
        for (const item of items) {
            if (item.value === value) {
                return item
            }
        }
        return null
    },

    strippedContent(string) {
        return string.replace(/<\/?[^>]+>/ig, " ");
    },

    removeQuote(string) {
        const regex = new RegExp(/<blockquote(.*?)>(.*)<\/blockquote>/i, 'si')
        return _.replace(string, regex, '');
    },

    countWords(string){
        return (_.split(_.replace(string,/<\/?[^>]+>/ig,''), ' ').length-1)
    }
};
