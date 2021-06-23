import * as React from 'react';
import { useDataProvider } from 'react-admin';
import { useMediaQuery, Theme } from '@material-ui/core';
import Welcome from './Welcome';

const Spacer = () => <span style={{ width: '1em' }} />;
const VerticalSpacer = () => <span style={{ height: '1em' }} />;

const styles = {
    flex: { display: 'flex' },
    flexColumn: { display: 'flex', flexDirection: 'column' },
    leftCol: { flex: 1, marginRight: '0.5em' },
    rightCol: { flex: 1, marginLeft: '0.5em' },
    singleCol: { marginTop: '1em', marginBottom: '1em' },
};

const Dashboard: React.FC = () => {
    const dataProvider = useDataProvider();
    // const [state, setState] = React.useState<State>({});
    const isXSmall = useMediaQuery((theme: Theme) =>
        theme.breakpoints.down('xs')
    );
    const isSmall = useMediaQuery((theme: Theme) =>
        theme.breakpoints.down('md')
    );

    return isXSmall ? (
        <div>
            <div style={styles.flexColumn as React.CSSProperties}>
                <Welcome />
                {/* <MonthlyRevenue value={revenue} />
                <VerticalSpacer />
                <PendingLiquidations value={pendingLiquidations} />
                <VerticalSpacer />
                <EmmitedLicenses value={emmittedLicenses} />
                <VerticalSpacer />
                <RegisteredTaxpayers value={registeredTaxpayers} />
                <VerticalSpacer />
                <CurrentPetroPrice value={currentPetroPrice} />
                <VerticalSpacer />
                <PaymentChart payments={payments} /> */}
            </div>
        </div>
    ) : isSmall ?  (
        <div style={styles.flexColumn as React.CSSProperties}>
            <div style={styles.singleCol}>
                <Welcome />
            </div>
            {/* <div style={styles.flex}>
                <MonthlyRevenue value={revenue} />
                <Spacer />
                <PendingLiquidations value={pendingLiquidations} />
                <Spacer />
                <CurrentPetroPrice value={currentPetroPrice} />
            </div>
            <VerticalSpacer />
            <div style={styles.flex}>
                <EmmitedLicenses value={emmittedLicenses} />
                <Spacer />
                <RegisteredTaxpayers value={registeredTaxpayers} />
            </div>
            <div style={styles.singleCol}>
                <PaymentChart payments={payments} />
            </div> */}
        </div>
    ) : (
        <>
            <Welcome />
            {/* <div style={styles.flex}>
                <div style={styles.leftCol}>
                    <div style={styles.flex}>
                        <MonthlyRevenue value={revenue} />
                    </div>
                    <div style={styles.singleCol}>
                        <PaymentChart payments={payments} />
                    </div>
                </div>
                <div style={styles.rightCol}>
                    <div style={styles.flexColumn as React.CSSProperties}>
                        <EmmitedLicenses value={emmittedLicenses} />
                        <VerticalSpacer />
                        <RegisteredTaxpayers value={registeredTaxpayers} />
                        <VerticalSpacer />
                        <PendingLiquidations value={pendingLiquidations} />
                        <VerticalSpacer />
                        <CurrentPetroPrice value={currentPetroPrice} />
                        <VerticalSpacer />
                    </div>
                </div>
            </div> */}
        </>
    );
};

export default Dashboard;
