import axios from 'axios';
import _ from 'lodash';

let globalConfig = {
    headers: {
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
    },
};

export default {
    get: async (uri, data = {}) => await axios.get(uri, data),
    upload: async (uri, data = {}) => await axios.post(uri, data, {
        headers: {
            'X-CSRF-TOKEN': globalConfig.headers["X-CSRF-TOKEN"],
            'Content-Type': 'multipart/form-data'
        },
    }),
    post: async (uri, data = {}) => await axios.post(uri, data, globalConfig),
    put: async (uri, data = {}) => await axios.put(uri, data, globalConfig),
    patch: async (uri, data = {}) => await axios.patch(uri, data, globalConfig),
    delete: async (uri) => await axios.delete(uri, globalConfig),
    postCors: async (uri, data = {}) => await axios.post(uri, data, {
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Headers': '*',
            'Access-Control-Allow-Methods': '*'
        }
    }),
    uploadCors: async (uri, data = {}) => await axios.post(uri, data, {
        headers: {
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Headers': '*',
            'Access-Control-Allow-Methods': '*',
            'Content-Type': 'multipart/form-data'
        },
    }),
    download: async (uri, method, data, file) => await axios.request({
        url: uri,
        method: method,
        responseType: 'blob',
        data,
    }).then(({data}) => {
        const downloadUrl = window.URL.createObjectURL(new Blob([data]));
        const link = document.createElement('a');
        link.href = downloadUrl;
        link.setAttribute('download', file);
        document.body.appendChild(link);
        link.click();
        link.remove();
    }),
    errors: (errorResponse) => {
        if (!errorResponse) {
            return null;
        }

        console.log(globalConfig)
        // If isset new csrf_token
        if (!_.isEmpty(_.get(errorResponse, 'data.csrf_token'))) {
            globalConfig.headers["X-CSRF-TOKEN"] = errorResponse.data.csrf_token
        }
        console.log(globalConfig)
        // If isset errors when form validate
        if (!_.isEmpty(_.get(errorResponse, 'data.errors'))) {
            const errors = errorResponse.data.errors;
            return errors[Object.keys(errors)[0]];
        }

        // Error for some case special
        if (!_.isEmpty(_.get(errorResponse, 'data.error'))) {
            const error = errorResponse.data.error;
            // eslint-disable-next-line no-console
            return errorResponse.status === 500
                ? 'Something wrong. Try again later!'
                : [error];
        }
        // Error when handle abort manual
        if (!_.isEmpty(_.get(errorResponse, 'data.message'))) {
            return [errorResponse.data.message];
        }

        return null;
    },
};
