import { Admin, Resource } from 'react-admin';
import { authProvider, dataProvider } from './providers';
import { history } from './utils';
import { Dashboard } from './dashboard';
import { Layout, Login } from './layouts';
// Resources
import users from './users';
import employees from './employees';

const App = () => (
    <Admin
        title=""
        layout={Layout}
        dashboard={Dashboard}
        history={history}
        loginPage={Login}
        authProvider={authProvider}
        dataProvider={dataProvider}
        disableTelemetry
    >
        {() => [
            <Resource {...users} />,
            <Resource {...employees} />
        ]}
    </Admin>
)

export default App;
