import * as React from 'react'
import {
    useEditController,
    EditContextProvider,
    EditProps,
    TextInput,
    SimpleForm
} from 'react-admin'

interface FormValues {
    membrete?: string;
    director_name?: string;
    position?: string;
    resolution?: string;
    rif?: string;
    address?: string;
}

const validate = (values: FormValues) => {
    const errors: FormValues = {};
  
    if (!values.membrete) {
        errors.membrete = 'Ingrese un texto para el '
    }
    if (!values.director_name) {
        errors.director_name = 'Ingrese el nombre del director'
    }
    if (!values.position) {
        errors.position = 'Ingrese el cargo'
    }
    if (!values.rif) {
        errors.rif = 'Ingrese el RIF de la institución'
    }
    if (!values.resolution) {
        errors.resolution = 'Ingrese los valores de la resolución del cargo'
    }
    if (!values.address) {
        errors.address = 'Ingrese la dirección de la institución'
    }

    return errors;
};

const ParametersEdit = (props: EditProps) => {
    const editControllerProps = useEditController({
        ...props,
        id: 1
    });

    const { record, save } = editControllerProps;

    return (
        <EditContextProvider value={editControllerProps}>
            <SimpleForm save={save} record={record} validate={validate}>
                <TextInput source="address" label='Dirección' />
                <TextInput source="rif" label='RIF' />
                <TextInput source="director_name" label='Director' />
                <TextInput source="resolution" label='Resolución' />
                <TextInput source="position" label='Cargo' />
                <TextInput source="membrete" label='Membrete' />
            </SimpleForm>
        </EditContextProvider>
    )
}

ParametersEdit.defaultProps = {
    basePath: '/parameters',
    resource: 'parameters'
}

export default ParametersEdit
