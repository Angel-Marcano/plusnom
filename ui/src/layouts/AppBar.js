import * as React from 'react'
import {
    makeStyles,
    Toolbar,
    useMediaQuery,
    Box,
    AppBar as MuiAppBar
} from '@material-ui/core';
// Icons
import ToggleSidebarButton from './ToggleSidebarButton';
import { useSelector } from 'react-redux';
import UserMenu from './UserMenu'
import { MenuItemLink } from 'react-admin'
import AccountBoxIcon from '@material-ui/icons/AccountBox';

const useStyles = makeStyles(theme => ({
        root: {
            backgroundColor: (props) => 
                props.isXSmall ? theme.palette.primary.main
                : theme.palette.background.default,
            width: (props) => 
                !props.isOpenSidebar && (!props.isXSmall) // Large screens
                    ? `calc(100% - 55px)` 
                : (props.isXSmall) // Small screen
                    ? '100%'
                : `calc(100% - 240px)`, // Large screen
            boxShadow: 'none',
            borderBottom: 0,
            transition: 'width 195ms cubic-bezier(0.4, 0, 0.6, 1) 0ms'
        },
        toolbar: {
            display: 'flex',
            justifyContent: 'space-between',
            paddingRight: 24,
            backgroundColor: 'transparent',
            flexDirection: (props) => 
                props.isXSmall 
                    ? 'row-reverse'
                    : 'row',
        },
        title: {
            flex: 1,
            textOverflow: 'ellipsis',
            whiteSpace: 'nowrap',
            overflow: 'hidden',
        },
    }),
    { name: 'RaAppBar' }
);

const CustomUserMenu = React.forwardRef((props, ref) => (
    <UserMenu {...props}>
        <Box>
            <MenuItemLink
                ref={ref}
                to="/profile"
                primaryText='Perfil'
                title='Configuraciones de perfil'
                leftIcon={<AccountBoxIcon />}
                onClick={props.onClick}
                sidebarIsOpen
            />
        </Box>
    </UserMenu>
));

const AppBar = ({ logout, ...rest }) => {
    const isXSmall = useMediaQuery(theme =>
        theme.breakpoints.down('xs')
    );
    const open = useSelector(state => state.admin.ui.sidebarOpen);
    const classes = useStyles({
        isOpenSidebar: open,
        isXSmall: isXSmall
    });
  
    return (
        <MuiAppBar className={classes.root} position='absolute' {...rest}>
            <Toolbar
                disableGutters
                variant={isXSmall ? 'regular' : 'dense'}
                className={classes.toolbar}
            >
                <ToggleSidebarButton />

                <CustomUserMenu logout={logout} />
            </Toolbar>
        </MuiAppBar>
    );
};

export default AppBar;
  