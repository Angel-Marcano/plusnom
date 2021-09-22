import { Admin, Resource } from 'react-admin';
import { authProvider, dataProvider } from './providers';
import { history } from './utils';
import { Dashboard } from './dashboard';
import { Layout, Login } from './layouts';
import customRoutes from './routes'
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
        customRoutes={customRoutes}
        disableTelemetry
    >
        {() => [
            <Resource {...users} />,
            <Resource {...employees} />,
            <Resource name='parameters' />
        ]}
    </Admin>
)

export default App;
