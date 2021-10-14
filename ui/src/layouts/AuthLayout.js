import * as React from 'react';
import { Form } from 'react-final-form';
import { createMuiTheme, makeStyles } from '@material-ui/core/styles';
import { ThemeProvider } from '@material-ui/styles';
import theme from './theming';
import { Typography, Box } from '@material-ui/core'

const useStyles = makeStyles(theme => ({
    main: {
        display: 'flex',
        flexDirection: 'row',
        minHeight: '100vh',
        justifyContent: 'center',
        zIndex: '1000',
        [theme.breakpoints.up('sm')]: {
            justifyContent: 'flex-end'
        }
    },
    outer: {
        position: 'absolute',
        top: '0',
        left: '0',
        width: '100%',
        height: '100%',
        zIndex: '-1',
        color: '#fff',
        background: theme.palette.primary.main,
    },
    title: {
        position: 'fixed',
        bottom: '2rem',
        left: '2rem',
        padding: '2rem',
        width: '30%'
    }
}));

const AuthLayout = ({ validate, handleSubmit, children, ...rest }) => {
    const classes = useStyles();

    return (
        <Form
            onSubmit={handleSubmit}
            validate={validate}
            {...rest}
            render={({ handleSubmit }) => (
                <form onSubmit={handleSubmit} noValidate>
                    <Box component='div' className={classes.outer}>
                        <Box component='div' className={classes.title}>
                            <img src={process.env.PUBLIC_URL + "/logo.png"} alt="plusnom_logo" />
                            <Typography variant='h5' component='h5'>
                                La mejor manera de aprender y compartir conocimiento sobre derecho,
                                esta en <strong>Approbado</strong>.
                            </Typography>
                        </Box>
                    </Box>
                    <Box component='div' className={classes.main}>
                        {
                            React.Children.map(children, (child) =>
                                React.cloneElement(child)
                            )
                        }
                    </Box>
                </form>
            )}
        />
    );
};

const AuthLayoutWithTheme = props => (
    <ThemeProvider theme={createMuiTheme(theme)}>
        <AuthLayout {...props} />
    </ThemeProvider>
);

export default AuthLayoutWithTheme;
