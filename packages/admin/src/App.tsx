import { Admin, Resource } from 'react-admin';
import { dataProvider, authProvider } from '@plusnom/common/providers';
import { history } from '@plusnom/common/utils';
import { Dashboard } from './dashboard';
import { Layout, Login } from './layouts';

import users from './users';

function App() {
  return (
    <Admin
      layout={Layout}
      history={history}
      dataProvider={dataProvider}
      loginPage={Login}
      dashboard={Dashboard}
      authProvider={authProvider}
    >
      <Resource {...users} />
    </Admin>
  );
}

export default App;
