import { FC, useState } from 'react';
import { useSelector } from 'react-redux';
import { useMediaQuery, Theme, Box } from '@material-ui/core';
import {
    DashboardMenuItem,
    MenuItemLink,
    MenuProps,
} from 'react-admin';
import SubMenu from './SubMenu';
import { AppState } from '../types';

// Menu icons
import LabelIcon from '@material-ui/icons/Label';

// Resources
import users from '../users';
import employees from '../employees';

type MenuName = 'administration';

const Menu: FC<MenuProps> = ({ onMenuClick, logout, dense = false }) => {
    const [state, setState] = useState({
        administration: false
    });
    const isXSmall = useMediaQuery((theme: Theme) =>
        theme.breakpoints.down('xs')
    );
    const open = useSelector((state: AppState) => state.admin.ui.sidebarOpen);

    const handleToggle = (menu: MenuName) => {
        setState(state => ({ ...state, [menu]: !state[menu] }));
    };

    return (
        <Box mt={1}>
            {' '}
            <DashboardMenuItem onClick={onMenuClick} sidebarIsOpen={open} />
            <MenuItemLink
                to={employees.name}
                primaryText={employees.options.label}
                leftIcon={<employees.icon />}
                onClick={onMenuClick}
                sidebarIsOpen={open}
                dense={dense}
            />
            <SubMenu
                handleToggle={() => handleToggle('administration')}
                isOpen={state.administration}
                sidebarIsOpen={open}
                name="Administración"
                icon={<LabelIcon />}
                dense={dense}
            >
                <MenuItemLink
                    to={users.name}
                    primaryText={users.options.label}
                    leftIcon={<users.icon />}
                    onClick={onMenuClick}
                    sidebarIsOpen={open}
                    dense={dense}
                />
            </SubMenu>
            {isXSmall && logout}
        </Box>
    );
};

export default Menu;
