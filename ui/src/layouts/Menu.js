import * as React from 'react';
import { useSelector } from 'react-redux';
import SettingsIcon from '@material-ui/icons/Settings';
import { useMediaQuery, Box } from '@material-ui/core';
import MonetizationOnIcon from '@material-ui/icons/MonetizationOn';
import {
    DashboardMenuItem,
    MenuItemLink,
} from 'react-admin';

const Menu = ({ onMenuClick, logout, dense = false }) => {
    const isXSmall = useMediaQuery(theme =>
        theme.breakpoints.down('xs')
    );
    const open = useSelector(state => state.admin.ui.sidebarOpen);

    return (
        <Box mt={1}>
            {' '}
            <DashboardMenuItem onClick={onMenuClick} sidebarIsOpen={open} />
            {/* <MenuItemLink
                to={trivias.name}
                primaryText={trivias.options.label}
                leftIcon={<trivias.icon />}
                onClick={onMenuClick}
                sidebarIsOpen={open}
                dense={dense}
            />
            <MenuItemLink
                to={users.name}
                primaryText={users.options.label}
                leftIcon={<users.icon />}
                onClick={onMenuClick}
                sidebarIsOpen={open}
                dense={dense}
            />
            <MenuItemLink
                to="/memberships"
                primaryText={'Planes y membresías'}
                leftIcon={<MonetizationOnIcon />}
                onClick={onMenuClick}
                sidebarIsOpen={open}
                dense={dense}
            />
            <MenuItemLink
                to="/configurations"
                primaryText={'Configuraciones'}
                leftIcon={<SettingsIcon />}
                onClick={onMenuClick}
                sidebarIsOpen={open}
                dense={dense}
            /> */}
        </Box>
    );
};

export default Menu;
