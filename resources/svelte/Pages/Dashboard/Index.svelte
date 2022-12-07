<script lang="ts">   
    import { onMount, onDestroy } from "svelte";
    import { Transaction, Balance } from "./../../../ts/types";
    import Pending from "./Pending.svelte";
    import Balances from "./Balances.svelte";

    let
        balances: Balance[],
        pendingTransactions: Transaction[],
        interval: NodeJS.Timer;

    async function loadDashboardData<T>(type: string): Promise<T | void>
    {
        return fetch(`/dashboard/${type}`)
                    .then<T>(response => response.json())
                    .catch(error => console.error(error));
    }

    function loadData(): void
    {
        loadDashboardData<Balance[]>('balances')
            .then(json => balances = json || []);
        loadDashboardData<Transaction[]>('pending')
            .then(json => pendingTransactions = json || []);
    }

    function initAutoRefresh(): void
    {
        loadData();
        interval = setInterval(loadData, 10000);
    }

    function stopAutoRefresh(): void
    {
        clearInterval(interval);
    }

    onMount(initAutoRefresh);
    onDestroy(stopAutoRefresh);
</script>

<main id="dashboard-page">
    <h1>Dashboard</h1>
    <Balances {balances} />
    <Pending transactions={pendingTransactions} />
</main>

<aside aria-hidden="true"></aside>