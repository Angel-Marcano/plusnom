import { Admin, Resource } from 'react-admin';
import { dataProvider, authProvider } from '@plusnom/common/providers';
import { history } from '@plusnom/common/utils';
import { Dashboard } from './dashboard';
import { Layout, Login } from './layouts';

import users from './users';
import employees from './employees';

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
      <Resource {...employees} />
    </Admin>
  );
}

export default App;
