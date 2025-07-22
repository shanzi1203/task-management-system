<x-mail::message>
# Task Assigned

Hello,

You have been assigned a new task.

**Title:** {{$task->title}}

**Description:** {{$task->description}}

**Due Date : ** {{$task->due_date}}


Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
