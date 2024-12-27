<div class="inline-flex items-center mx-auto space-x-3">
    <form action="{{ route('queue.update', ['ulid' => $queue->ulid]) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="hidden" name="doctor_id" value="{{ $doctor_id }}">
        <button type="submit" class="text-primary">
            Select
        </button>
    </form>
</div>