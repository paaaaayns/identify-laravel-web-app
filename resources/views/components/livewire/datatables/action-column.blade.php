<div class="inline-flex items-center mx-auto space-x-3">
    <a 
        href="{{ $viewLink }}"
        class="text-primary">
        View
    </a>

    <a 
        href="{{ $editLink }}"
        class="text-indigo-500">
        Edit
    </a>

    <form
        action="{{ $deleteLink }}"
        class="d-inline"
        method="POST"
        x-data
        @submit.prevent="if (confirm('Are you sure you want to delete this user?')) $el.submit()">
        @method('DELETE')
        @csrf
        <button type="submit" class="btn btn-link text-red-500">
            Delete
        </button>
    </form>
</div>