import { Admin, Resource } from 'react-admin'
import Dashboard from './dashboard'
import Layout from './layouts'
import Login from './layouts/Login'
import { dataProvider, authProvider, browserHistory } from './providers'

const App = () => (
    <Admin
        dashboard={Dashboard}
        history={browserHistory}
        layout={Layout}
        dataProvider={dataProvider}
        loginPage={Login}
        authProvider={authProvider}
    >
        <Resource name="profile" />
    </Admin>
)

export default App;
