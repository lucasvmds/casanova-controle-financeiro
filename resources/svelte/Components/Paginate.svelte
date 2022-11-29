<script lang="ts" context="module">
    export type Paginate<T = Object> = {
        current_page: number;
        per_page: number;
        last_page: number;
        data: T[];
        total: number;
    }
</script>

<script lang="ts">
    import { Select } from "./Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";
    export let pages: Paginate, step: string, max: string;

    const maxNumber: number = parseInt(max);
    const stepNumber: number = parseInt(step);

    $: currentPage = pages.current_page;
    $: currentItems = pages.per_page;
    
    function changePage(): void
    {
        const data = Object.fromEntries<string | number | null>(
            new URLSearchParams(location.search)
        );
        delete data.page;
        delete data.items;
        currentPage > 1 ? data.page = currentPage : null;
        currentItems > stepNumber ? data.items = currentItems : null;
        Inertia.get(location.pathname, data, { preserveScroll: true });
    }
</script>

<div class="paginate-component">
    <Select label="Página" bind:value={currentPage} error="" on:change={changePage}>
        {#each Array(pages.last_page) as _, index}
            {@const page = ++index}
            <option value={page}>{page}</option>
        {/each}
    </Select>
    <Select label="Itens por página" bind:value={currentItems} error="" on:change={changePage}>
        {#each Array(maxNumber / stepNumber) as _, index}
            {@const items = (index + 1) * stepNumber}
            <option value={items}>{items}</option>
        {/each}
    </Select>
</div>