<script lang="ts">
    type Group = {
        t_group_id: string;
        last_transaction_date: string;
        name: string;
        count: number;
    }
    
    import { makeDate } from "../../../ts/support";
    import { Link } from "@inertiajs/inertia-svelte";
    import PaginateComponent, { Paginate } from "../../Components/Paginate.svelte";
    import { SearchButton, SearchForm } from "./Search/index.svelte";
    import { Segment } from "../../../ts/types";
    export let
        groups: Paginate<Group>,
        pending_count: number,
        segments: Segment[];
</script>

<main>
    <h1>Transações Agrupadas</h1>
    <SearchForm {segments} />
    <table class="center">
        <thead>
            <tr>
                <th>Código</th>
                <th>Segmento</th>
                <th>Transações</th>
                <th>Última transação</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            {#each groups.data as group}
                <tr>
                    <td>{group.t_group_id}</td>
                    <td>{group.name}</td>
                    <td>{group.count}</td>
                    <td>{makeDate(group.last_transaction_date).format('d/m/Y H:i')}</td>
                    <td class="actions">
                        <Link href="/transactions/{group.t_group_id}" title="exibir transações agrupadas">
                            <i class="fa-duotone fa-square-info edit"></i>
                        </Link>
                    </td>
                </tr>
            {:else}
                <tr>
                    <td colspan="5">Não foram encontrados registros no momento</td>
                </tr>
            {/each}
        </tbody>
    </table>
    <PaginateComponent pages={groups} step="20" max="100" />
</main>

<aside>
    <Link href="/transactions/create">
        Adicionar transação
    </Link>
    <Link href="/transactions">
        Transações
    </Link>
    <Link href="/transactions/pending">
        Pendentes ({pending_count})
    </Link>
    <SearchButton />
</aside>