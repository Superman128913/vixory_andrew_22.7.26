export default function(models, keyName = "name"){
    var kv_pairs = [];
    for(var i = 0; i < models.length; i++)
    {
        kv_pairs.push({
            'key':models[i][keyName],
            'value':models[i]['id']
        });
    }
    return kv_pairs;
}