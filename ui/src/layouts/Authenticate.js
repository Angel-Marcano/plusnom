import * as React from 'react';
import PropTypes from 'prop-types';
import { useParams } from 'react-router-dom';
import Box from '@material-ui/core/Box';
import CircularProgress from '@material-ui/core/CircularProgress';
import { createMuiTheme, ThemeProvider, makeStyles } from '@material-ui/core/styles';
import theme from './theming';
import { useLogin } from 'react-admin';

const useStyles = makeStyles(theme => ({
    root: {
        display: 'flex',
        height: '100vh',
        justifyContent: 'center',
        alignItems: 'center',
        backgroundColor: theme.palette.secondary.main
    },
    loader: {
        height: '5em !important',
        width: '5em !important',
    }
}));

const Login = () => {
  const { auth } = useParams()
  const login = useLogin()
  const classes = useStyles()

  React.useEffect(() => {
    if (auth) {
      login(auth, '/')
    }
  }, [auth, login])

    return (
        <Box className={classes.root}>
            <CircularProgress className={classes.loader}/>
        </Box>
    );
};

Login.propTypes = {
  authProvider: PropTypes.func,
};

const LoginWithTheme = (props) => (
  <ThemeProvider theme={createMuiTheme(theme)}>
    <Login {...props} />
  </ThemeProvider>
);

export default LoginWithTheme;
