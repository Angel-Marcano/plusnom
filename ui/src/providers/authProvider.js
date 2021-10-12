import { dataProvider } from './dataProvider';

const CONFIG_NAMES = {
  IDENTIFICATION: `${process.env.REACT_APP_IDENTIFICATIONS_NAME}`,
  AUTH_TOKEN: `${process.env.REACT_APP_AUTH_TOKEN_NAME}`,
  PERMISSIONS: `${process.env.REACT_APP_PERMISSIONS_NAME}`,
}

export const authProvider = {
  login: async (data) => {
    await localStorage.setItem(CONFIG_NAMES.AUTH_TOKEN, data);

    return Promise.resolve();
  },
  logout: async () => {
    // await localStorage.removeItem(CONFIG_NAMES.AUTH_TOKEN);
    // await localStorage.removeItem(CONFIG_NAMES.IDENTIFICATION);
    // await localStorage.removeItem(CONFIG_NAMES.PERMISSIONS);

    return Promise.resolve();
  },
  checkError: async (error) => {
    // const { response } = error;

    // if (response.status === 401 || response.status === 403) {
    //   await localStorage.removeItem(CONFIG_NAMES.AUTH_TOKEN);
    //   await localStorage.removeItem(CONFIG_NAMES.IDENTIFICATION);
    //   await localStorage.removeItem(CONFIG_NAMES.PERMISSIONS);
    //   return Promise.reject({ message: false });
    // }

    return Promise.resolve();
  },
  checkAuth: async () => Promise.resolve(),
  // await localStorage.getItem(CONFIG_NAMES.AUTH_TOKEN)
  //   ? Promise.resolve()
  //   : Promise.reject({ redirectTo: '/' }),
  getPermissions: async () => {
    // const permissions = await localStorage.getItem(CONFIG_NAMES.PERMISSIONS);

    // return permissions ? Promise.resolve(permissions) : Promise.resolve('guest');
    return Promise.resolve()
  },
  getIdentity: async () => {
    // const token = await localStorage.getItem(CONFIG_NAMES.IDENTIFICATION);

    // if (token) {
    //   const { id, full_name, picture, ...rest } = JSON.parse(token);

    //   return ({
    //     id: id,
    //     full_name: full_name,
    //     avatar: picture,
    //     ...rest
    //   });
    // }
    return Promise.resolve()
  }
};
