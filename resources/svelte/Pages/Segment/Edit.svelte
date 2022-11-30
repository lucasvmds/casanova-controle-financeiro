<script lang="ts">
    type Data = {
        name: string;
    }

    import { Input, Errors } from "../../Components/Form/index.svelte";
    import { Inertia } from "@inertiajs/inertia";
    import { Link } from "@inertiajs/inertia-svelte";
    import { Segment } from "../../../ts/types";
    export let
        segment: Segment,
        errors: Errors<Data>;

    const DATA: Data = {
        name: segment.name,
    };

    function editSegment(): void
    {
        Inertia.patch(`/segments/${segment.id}`, DATA, {
            preserveScroll: true,
        });
    }
</script>

<main>
    <h1>Editar segmento {segment.name}</h1>
    <form on:submit|preventDefault={editSegment} id="form-edit-segment">
        <Input type="text" label="Nome" required bind:value={DATA.name} error={errors.name} size=50 />
    </form>
</main>

<aside>
    <button type="submit" form="form-edit-segment">
        Salvar
    </button>
    <Link href="/segments">
        Voltar
    </Link>
</aside>
