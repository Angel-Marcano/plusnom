import apiClient from 'ra-laravel-client';

const dataProvider = apiClient(`${process.env.REACT_APP_API_DOMAIN}/api`, {
  withCredentials: true
}, `${process.env.REACT_APP_AUTH_TOKEN_NAME}`);

const customDataProvider = {
  ...dataProvider,
  create: (resource: any, params: any) => {
    if (resource !== 'organizations' || !params.data.logo) {
      // fallback to the default implementation
      return dataProvider.create(resource, params);
    }

    const formData = new FormData();
    const { logo, ...rest } = params.data;

    formData.append('logo', logo.rawFile);

    for (let [key, value] of Object.entries(rest)) {
      formData.append(key, <string>value);
    };

    return dataProvider.create(resource, {
      data: formData
    });
  },

  importUsers: (data: any ) => {
    const { file, ...rest } = data;
    const formData = new FormData();
    formData.append('file', file.rawFile);

    for (let [key, value] of Object.entries(rest)) {
      formData.append(key, <string>value);
    };

    return dataProvider.post('users/import', formData );
  }
};

export default customDataProvider;
