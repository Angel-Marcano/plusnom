import * as React from "react";
import {
  Filter,
  TextInput,
  List,
  Datagrid,
  TextField,
  SimpleList,
  BooleanInput,
  BooleanField
} from 'react-admin';
import { Theme, useMediaQuery } from '@material-ui/core';

const EmployeesFilter: React.FC = props => (
  <Filter {...props}>
    <TextInput label="Cédula" source='document' />
    <TextInput label="Nombre" source='full_name' />
  </Filter>
);

const EmployeesList: React.FC = props => {
  const isSmall = useMediaQuery<Theme>(theme => theme.breakpoints.down('sm'));

  return (
    <List {...props}
      title="Empleados"
      bulkActionButtons={false}
      filters={<EmployeesFilter />}
      exporter={false}
    >
      {
        isSmall
        ? (
          <SimpleList
            primaryText={record => `${record.full_name}`}
          />
        )
        : (
          <Datagrid>
            <TextField source="document" label="Cédula"/>
            <BooleanField source="active" label="Activo"/>
            <TextField source="full_name" label="Nombre completo"/>
          </Datagrid>
        )
      }
    </List>
  );
};

export default EmployeesList;
