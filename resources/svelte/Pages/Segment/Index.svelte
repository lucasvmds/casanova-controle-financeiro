<script lang="ts">
    import { Button } from "../../Components/Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import { Link } from "@inertiajs/inertia-svelte";
    import { Segment } from "../../../ts/types";
    export let segments: Segment[];

    function changeSegmentStatus(id: number): void
    {
        Inertia.delete(`/segments/${id}`, { preserveScroll: true })
    }
</script>

<main>
    <h1>Segmentos</h1>
    <table class="center">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            {#each segments as segment}
                <tr>
                    <td>{segment.name}</td>
                    <td class="actions">
                        {#if segment.active}
                            <Link href="/segments/{segment.id}/edit">
                                <i class="fa-duotone fa-pen-square edit"></i>
                            </Link>
                            <Button type="button" on:click={() => changeSegmentStatus(segment.id)}>
                                <i class="fa-duotone fa-square-xmark delete"></i>
                            </Button>
                        {:else}
                            <Button type="button" on:click={() => changeSegmentStatus(segment.id)}>
                                <i class="fa-duotone fa-square-check save"></i>
                            </Button>
                        {/if}
                    </td>
                </tr>
            {:else}
                <tr>
                    <td colspan="2">Não foram encontrados registros</td>
                </tr>
            {/each}
        </tbody>
    </table>
</main>

<aside>
    <Link href="/segments/create">
        Adicionar segmento
    </Link>
</aside>