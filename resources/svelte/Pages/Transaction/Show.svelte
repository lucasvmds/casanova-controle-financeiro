<script lang="ts">
    import { Transaction } from "../../../ts/types";
    import { Link } from "@inertiajs/inertia-svelte";
    import { makeDate } from "../../../ts/support";
    import Type from "./Type.svelte";
    export let
        transactions: Transaction[],
        total_in: string,
        total_out: string,
        total_profit: string;
</script>

<main id="transactions-show-page">
    <h1>Transações Grupo {transactions.length > 0 ? transactions[0].group_id : '-'}</h1>
    <table class="center">
        <thead>
            <tr>
                <th>Código</th>
                <th>Segmento</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Tipo</th>
                <th>Pendente</th>
                <th>Data</th>
            </tr>
        </thead>
        <tbody>
            {#each transactions as transaction}
                <tr>
                    <td>{transaction.group_id || '-'}</td>
                    <td>{transaction.segment_name}</td>
                    <td>{transaction.description}</td>
                    <td>{transaction.amount}</td>
                    <td>
                        <Type type={transaction.type} />
                    </td>
                    <td>{transaction.pending ? 'Sim' : 'Não'}</td>
                    <td>{makeDate(transaction.created_at).format('d/m/Y H:i')}</td>
                </tr>
            {:else}
                <tr>
                    <td colspan="7">Não foram encontrados registros no momento</td>
                </tr>
            {/each}
        </tbody>
    </table>
    <table class="grouped-amount">
        <thead>
            <tr>
                <th>Entradas</th>
                <th>Saídas</th>
                <th>Lucro</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{total_in}</td>
                <td>{total_out}</td>
                <td>{total_profit}</td>
            </tr>
        </tbody>
    </table>
</main>

<aside>
    <Link href="/transactions/grouped">
        Voltar
    </Link>
</aside>