import { Route } from 'react-router-dom';
import ParametersEdit from './parameters/ParametersEdit'

export default [
    <Route 
        path="/parameters" 
        render={() => <ParametersEdit />} 
    />
];

