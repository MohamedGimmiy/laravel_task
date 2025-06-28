<p>Hello {{ $task->user->name }},</p>
<p>This is a reminder that your task <strong>"{{ $task->title }}"</strong> is due on {{ $task->due_date }}.</p>
<p>Please make sure it's completed on time.</p>