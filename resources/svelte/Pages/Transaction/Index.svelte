<script lang="ts">
    import { Transaction } from "../../../ts/types";
    import { Link } from "@inertiajs/inertia-svelte";
    import PaginateComponent, { Paginate } from "../../Components/Paginate.svelte";
    import Type from "./Type.svelte";
    import { makeDate } from "../../../ts/support";
    import { SearchButton, SearchForm } from "./Search/index.svelte";
    export let
        transactions: Paginate<Transaction>,
        pending_count: number;
</script>

<main>
    <h1>Transações</h1>
    <SearchForm />
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
            {#each transactions.data as transaction}
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
    
    <PaginateComponent pages={transactions} step="20" max="100" />
</main>

<aside>
    <Link href="/transactions/create">
        Adicionar transação
    </Link>
    <Link href="/transactions/pending">
        Pendentes ({pending_count})
    </Link>
    <Link href="/transactions/grouped">
        Agrupadas
    </Link>
    <SearchButton />
</aside>