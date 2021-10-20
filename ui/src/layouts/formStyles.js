import { makeStyles, fade } from '@material-ui/core/styles';

const useStyles = makeStyles(theme => ({
    root: {
        alignItems: 'center',
        flexDirection: 'column',
        padding: '1em 0'
    },
    card: {
        display: 'flex',
        flexDirection: 'column',
        justifyContent: 'center',
        alignItems: 'center',
        minWidth: '100%',
        minHeight: '100%',
        [theme.breakpoints.up('sm')]: {
            minWidth: '50%'
        }
    },
    link: {
        textDecoration: 'underline',
        color: theme.palette.primary.main,
        '&visited': {
            color: theme.palette.primary.main,
        }
    },
    icon: {
        backgroundColor: theme.palette.secondary.main,
    },
    form: {
        padding: '2em',
        maxWidth: '500px',
        alignItems: 'center',
        flexDirection: 'column',
        padding: '1em 0'
    },
    input: {
        marginTop: '1em',
    },
    actions: {
        marginTop: '2em',
        marginBottom: '2em',
        display: 'flex',
        justifyContent: 'center',
        flexDirection: 'column'
    },
    saveButton: {
        padding: '0.7rem 2rem',
        textTransform: 'none',
        fontSize: '16px',
        borderRadius: '6px',
        '&:hover': {
            backgroundColor: fade(theme.palette.secondary.main, 0.95)
        }
    }
}));

export default useStyles;
