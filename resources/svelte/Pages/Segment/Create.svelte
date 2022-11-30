<script lang="ts">
    type Data = {
        name: string;
    }

    import { Input, Errors } from "../../Components/Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import { Link } from "@inertiajs/inertia-svelte";
    export let errors: Errors<Data>;

    const DATA: Data = {
        name: null,
    };

    function createSegment(): void
    {
        Inertia.post('/segments', DATA, {
            preserveScroll: true,
        });
    }
</script>

<main>
    <h1>Adicionar segmento</h1>
    <form on:submit|preventDefault={createSegment} id="form-create-segment">
        <Input type="text" label="Nome" required bind:value={DATA.name} error={errors.name} size=50 />
    </form>
</main>

<aside>
    <button type="submit" form="form-create-segment">
        Salvar
    </button>
    <Link href="/segments">
        Voltar
    </Link>
</aside>
