<script lang="ts">
    import { Inertia } from "@inertiajs/inertia";
    import { Link } from "@inertiajs/inertia-svelte";

    function logoutUser(): void
    {
        Inertia.delete('/session', {
            preserveScroll: true
        });
    }
</script>

<header id="app-header">
    <nav>
        <Link href="/">Dashboard</Link>
        <Link href="/transactions">Transações</Link>
        <Link href="/extracts">Extratos</Link>
        <Link href="/session/edit">Acesso</Link>
        <button type="button" on:click={logoutUser}>
            Sair
        </button>
    </nav>
</header>