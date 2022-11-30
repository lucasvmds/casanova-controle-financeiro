<script lang="ts">
    type Filters = {
        initial_date: string;
        final_date: string;
    }

    import { Transaction, Segment } from "../../../ts/types";
    import { Link } from "@inertiajs/inertia-svelte";
    import Type from "../Transaction/Type.svelte";
    import { makeDate } from "../../../ts/support";
    export let
        transactions: Transaction[],
        segment: Segment,
        filters: Filters,
        initial_balance: string,
        final_balance: string;

    const INITIAL_DATE = makeDate(filters.initial_date).format('d/m/Y', true);
    const FINAL_DATE = makeDate(filters.final_date).format('d/m/Y', true);
</script>

<main id="extracts-show-page">
    <h1>Extrato {segment.name}</h1>
    <p>
        <b>Período:</b> {INITIAL_DATE} - {FINAL_DATE}
    </p>
    <dl>
        <dt>
            <b>Saldo no dia {INITIAL_DATE}</b>
        </dt>
        <dd>{initial_balance}</dd>
        <dt>
            <b>Saldo no dia {FINAL_DATE}</b>
        </dt>
        <dd>{final_balance}</dd>
    </dl>
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
</main>

<aside>
    <button type="button" on:click={() => window.print()}>
        Imprimir
    </button>
    <Link href="/extracts">
        Voltar
    </Link>
</aside>