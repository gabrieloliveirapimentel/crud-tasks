<?php

namespace App\Models;

use MongoDB\Client;

class LogsModel
{
    protected $client;
    protected $collection;

    public function __construct()
    {
        $this->client = new Client(sprintf(
            'mongodb://%s:%s@%s:%s',
            env('MONGO_DB_USERNAME', 'root'),
            env('MONGO_DB_PASSWORD', 'root123'),
            env('MONGO_DB_HOST', 'mongo_db'),
            env('MONGO_DB_PORT', 27017)
        ));
       
        $this->collection = $this->client->selectDatabase(env('MONGO_DB_DATABASE', 'mongo_schema'))
                                        ->selectCollection('logs');
    }

    public function createLog(array $data)
    {
        return $this->collection->insertOne($data);
    }

    public function getAllLogs(array $filters = [])
    {
        $options = [
            'sort' => ['created_at' => -1],
            'limit' => 30 
        ];

        if (!empty($filters)) {
            return $this->collection->find($filters, $options)->toArray();
        }

        return $this->collection->find([], $options)->toArray();
    }

    public function getLogById(string $id)
    {
        return $this->collection->findOne(['_id' => $id]);
    }

    public function deleteLog(string $id)
    {
        return $this->collection->deleteOne(['_id' => $id]);
    }

    public function clearOldLogs(int $daysOld = 10): int
    {
        $cutoffDate = new \DateTime();
        $cutoffDate->sub(new \DateInterval("P{$daysOld}D"));
        $cutoffDateString = $cutoffDate->format('Y-m-d\TH:i:s.v\Z');

        $result = $this->collection->deleteMany([
            'created_at' => ['$lt' => $cutoffDateString]
        ]);

        return $result->getDeletedCount();
    }
}
