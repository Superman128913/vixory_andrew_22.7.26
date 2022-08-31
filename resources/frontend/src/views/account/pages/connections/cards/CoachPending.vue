<template>
    <div class="border border-gray-alt2 rounded-lg">
        <div class="p-4">
            <p class="py-2">Connection requested on {{formatTimestamp(connection.athlete.created_at)}}.</p>
            <div>
                <div class="inline-flex px-2">
                    <span>
                        <span class="text-accent text-lg px-1"><i class="fas fa-address-card"></i></span> Age
                    </span>
                    <span class="px-2 leading-7">{{connection.athlete.age}}</span>
                </div>
                <div class="inline-flex px-2">
                    <span>
                        <span class="text-accent text-lg px-1"><i class="fas fa-ruler-vertical"></i></span> Height
                    </span>
                    <span class="px-2 leading-7">{{connection.athlete.height | length}}</span>
                </div>
                <div class="inline-flex px-2">
                    <span>
                        <span class="text-accent text-lg px-1"><i class="fas fa-weight"></i></span> Weight
                    </span>
                    <span class="px-2 leading-7">{{connection.athlete.weight}}</span>
                </div>
            </div>
        </div>
        <hr>
        <div class="text-center p-4">
            <ConnectionStatus :connection="connection"/>
        </div>
    </div>
</template>
<script>
//Show this card if the active user is a coach who is looking at a request they made that hasn't been accepted.
export default {
    name:"CoachPending",
    props:["connection"]
}
</script>