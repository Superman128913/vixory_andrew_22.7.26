<template>
    <div>
        <AthletePanel/>
        <CoachPanel />
    </div>
</template>
<script>
import AthletePanel from './AthletePanel'
import CoachPanel from './CoachPanel'
import IconHealthy from './icons/IconHealthy';
import IconUnhealthy from './icons/IconUnhealthy';

export default {
    components: {
        AthletePanel,
        CoachPanel,
        IconHealthy,
        IconUnhealthy,
    }
}
</script>