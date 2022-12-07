<script lang="ts">
    import { makeDate } from "../../../ts/support";
    import { Transaction, Segment } from "../../../ts/types";
    import { Link } from "@inertiajs/inertia-svelte";
    import Type from "./Type.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import PaginateComponent, { Paginate } from "../../Components/Paginate.svelte";
    import { SearchButton, SearchForm } from "./Search/index.svelte";
    export let
        transactions: Paginate<Transaction>,
        segments: Segment[];

    function releaseTransaction(id: number): void
    {
        Inertia.patch(`/transactions/${id}/release`, {}, {
            preserveScroll: true,
        });
    }
</script>

<main>
    <h1>Transações Pendentes</h1>
    <SearchForm {segments} />
    <table class="center">
        <thead>
            <tr>
                <th>Código</th>
                <th>Segmento</th>
                <th>Descrição</th>
                <th>Valor</th>
                <th>Tipo</th>
                <th>Data validação</th>
                <th>Data</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            {#each transactions.data as transaction}
                <tr>
                    <td>{transaction.group_id || '-'}</td>
                    <td>{transaction.segment_name}</td>
                    <td>{transaction.description}</td>
                    <td>{transaction.amount}</td>
                    <td>
                        <Type type={transaction.type} />
                    </td>
                    <td>{makeDate(transaction.valid_at).format('d/m/Y', true)}</td>
                    <td>{makeDate(transaction.created_at).format('d/m/Y H:i')}</td>
                    <td class="actions">
                        <Link href="/transactions/{transaction.id}/edit" title="editar transação">
                            <i class="fa-duotone fa-pen-square edit"></i>
                        </Link>
                        <button type="button" title="lançar transação" on:click={() => releaseTransaction(transaction.id)}>
                            <i class="fa-duotone fa-square-dollar save"></i>
                        </button>
                    </td>
                </tr>
            {:else}
                <tr>
                    <td colspan="8">Não foram encontrados registros no momento</td>
                </tr>
            {/each}
        </tbody>
    </table>
    <PaginateComponent pages={transactions} max="100" step="20" />
</main>

<aside>
    <Link href="/transactions/create">
        Adicionar transação
    </Link>
    <Link href="/transactions">
        Transações
    </Link>
    <Link href="/transactions/grouped">
        Agrupadas
    </Link>
    <SearchButton />
</aside>