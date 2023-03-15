<?php

namespace bin\database\querybilder;

class querybuilder
{

    private $table;
    private $where;
    private $like;
    private $match;
    private $between;
    private $and;
    private $order;
    private $join;
    private $limit;
    private $limit_i;
    private $group;
    private $insert;
    private $values;
    private $set;
    private $set_i;
    private $replace;
    private $having;
    private $or;
    private $is;

    /**
     * table
     *
     * @param string $table
     * @return self
     */
    public function table(string $table): self
    {

        $this->table = "$table";

        return $this;
    }

    /**
     * insert
     *
     * @param string $insert
     * @return self
     */
    public function insert(string $insert): self
    {

        $this->insert = "$insert";

        return $this;
    }

    /**
     * values
     *
     * @param string $values
     * @return self
     */
    public function values(string $values): self
    {

        $this->values = "$values";

        return $this;
    }

    /**
     * where
     *
     * @param string $where
     * @return self
     */
    public function where(string $where, ?string $type = null): self
    {
        if ($type == null) {
            $this->where = "$where = ?";
        } else {
            $this->where = "$where $type ?";
        }

        return $this;
    }

    /**
     * like
     *
     * @param string $like
     * @return self
     */
    public function like(string $like): self
    {

        $this->like = "$like";

        return $this;
    }

    /**
     * like
     *
     * @param string $like
     * @return self
     */
    public function match(string $match): self
    {

        $this->match = "$match";

        return $this;
    }

    /**
     * like
     *
     * @param string $between
     * @param string $first
     * @param string $second
     * @return self
     */
    public function between(string $between): self
    {

        $this->between = "$between";

        return $this;
    }

    /**
     * limit
     *
     * @param string $begining
     * @param string $end
     * @return self
     */
    public function limit(string $begining, string $end): self
    {

        $this->limit = "LIMIT $begining,$end";

        return $this;
    }

    /**
     * limit
     *
     * @param string $begining
     * @param string $end
     * @return self
     */
    public function is(string $type, string $propriete): self
    {

        $this->is = " AND $propriete IS $type";

        return $this;
    }

    /**
     * limit
     *
     * @param string $begining
     * @param string $end
     * @return self
     */
    public function having(string $count, string $sign): self
    {

        $this->having = "HAVING COUNT($count) $sign ?";

        return $this;
    }

    /**
     * limit
     *
     * @param string $begining
     * @param string $end
     * @return self
     */
    public function limit_i(int $limit): self
    {

        $this->limit_i = "LIMIT $limit";

        return $this;
    }

    /**
     * order by
     *
     * @param string $key
     * @param string $direction
     * @return self
     */
    public function orderBy(string $key, string $direction): self
    {

        $this->order = "ORDER BY $key $direction";

        return $this;
    }

    /**
     * group by
     *
     * @param string $group
     * @return self
     */
    public function groupBy(string $group): self
    {
        $this->group = "GROUP BY $group";

        return $this;
    }

    /**
     * and
     *
     * @param array $getand
     * @return self
     */
    public function and($getand = []): self
    {

        foreach ($getand as $val) {
            $this->and .= " AND " . $val . " = ? ";
        }

        return $this;
    }

    /**
     * and
     *
     * @param array $getor
     * @return self
     */
    public function or($getor = []): self
    {

        foreach ($getor as $val) {
            $this->or .= " OR " . $val . " = ? ";
        }

        return $this;
    }

    /**
     * join
     *
     * @param array $getjoin
     * @return self
     */
    public function join($getjoin = []): self
    {

        foreach ($getjoin as $val) {

            $this->join .= ' JOIN ' . str_replace('|', ' ON ', $val);
        }

        return $this;
    }

    /**
     * set
     *
     * @param array $getset
     * @return self
     */
    public function set($getset = []): self
    {

        foreach ($getset as $val) {

            $this->set .= $val . " = ?" . " , ";
        }

        $this->set = rtrim($this->set, " , ");

        return $this;
    }

    /**
     * set
     *
     * @param array $getset
     * @param string $sign
     * @return self
     */
    public function set_i($getset = [], ?string $sign = "+"): self
    {

        foreach ($getset as $val) {

            $this->set_i .= $val . " = $val $sign ?" . " , ";
        }

        $this->set_i = rtrim($this->set_i, " , ");

        return $this;
    }

    /**
     * replace
     *
     * @param array $getreplace
     * @return self
     */
    public function replace($propriete = []): self
    {

        foreach ($propriete as $val) {

            $this->replace .= $val . " = REPLACE( $val , ? , ? ) , ";
        }

        $this->replace = rtrim($this->replace, " , ");

        return $this;
    }

    /**
     * select query chaine
     *
     * @param array|null $propriety
     * @return string
     */
    public function SQuery($propriety): string
    {

        if ($propriety === NULL) {
            $propriety = '*';
        }

        /* 
            Select initial query chaine
        */
        $query = "SELECT $propriety FROM {$this->table}";

        /* 
            Add join if exist
        */
        if ($this->join) {

            $query .= " {$this->join}";
        }

        /* 
            Add where if exist
        */
        if ($this->where) {
            $query .= " WHERE {$this->where}";
        }

        /* 
            Add LIKE if exist
        */
        if ($this->like) {
            $query .= " WHERE {$this->like} LIKE ?";
        }

        /* 
            Add match if exist
        */
        if ($this->match) {
            $query .= " WHERE MATCH ({$this->match}) AGAINST (?)";
        }

        /* 
            Add BETWEEN if exist
        */
        if ($this->between) {
            $query .= " WHERE {$this->between} BETWEEN ? AND ? ";
        }

        /* 
            Add AND if exist
        */
        if ($this->and) {
            $query .= "{$this->and}";
        }

        /* 
            Add IS NOT NULL OR IS NULL if exist
        */
        if ($this->is) {
            $query .= " {$this->is}";
        }

        /* 
            Add OR if exist
        */
        if ($this->or) {
            $query .= "{$this->or}";
        }

        /* 
            Add ORDER BY if exist
        */
        if ($this->order) {
            $query .= " {$this->order}";
        }

        /* 
            Add GROUP BY if exist
        */
        if ($this->group) {
            $query .= " {$this->group}";
        }

        /* 
            Add HAVING if exist
        */
        if ($this->having) {
            $query .= " {$this->having}";
        }

        /* 
            Add LIMIT if exist
        */
        if ($this->limit) {
            $query .= " {$this->limit}";
        }

        return $query;
    }


    /**
     * insert query chaine
     *
     * @return string
     */
    public function IQuery()
    {

        /* 
            Insert initial query chaine
        */
        $Iquery = "INSERT INTO {$this->table} ";

        /* 
            Add DATAS if exist
        */
        if ($this->insert) {
            $Iquery .= "( {$this->insert} )";
        }

        /* 
            Add VALUES if exist
        */
        if ($this->values) {
            $Iquery .= " VALUES ( {$this->values} )";
        }

        return $Iquery;
    }


    /**
     * Update query chaine
     *  @return mixed
     */
    public function UQuery()
    {

        /* 
            Update inital query chaine
        */
        $query = "UPDATE {$this->table} ";

        /* 
            Add join if exist
        */
        if ($this->join) {

            $query .= " {$this->join}";
        }

        /* 
            Add SET if exist
        */
        if ($this->set) {
            $query .= " SET {$this->set}";
        }

        /* 
            Add SET if exist
        */
        if ($this->set_i) {
            $query .= " SET {$this->set_i}";
        }

        /* 
            Add REPLACE if exist
        */
        if ($this->replace) {
            $query .= " SET {$this->replace}";
        }

        /* 
            Add WHERE if exist
        */
        if ($this->where) {
            $query .= " WHERE {$this->where} ";
        }

        /* 
            Add IS NOT NULL OR IS NULL if exist
        */
        if ($this->is) {
            $query .= " {$this->is}";
        }

        /* 
            Add match if exist
        */
        if ($this->match) {
            $query .= " WHERE MATCH ({$this->match}) AGAINST (?)";
        }

        /* 
            Add BETWEEN if exist
        */
        if ($this->between) {
            $query .= " WHERE {$this->between} BETWEEN ? AND ? ";
        }

        /* 
            Add LIKE if exist
        */
        if ($this->like) {
            $query .= " WHERE {$this->like} LIKE ? ";
        }

        /* 
            Add AND if exist
        */
        if ($this->and) {
            $query .= " {$this->and}";
        }

        /* 
            Add OR if exist
        */
        if ($this->or) {
            $query .= "{$this->or}";
        }

        /* 
            Add ORDER BY if exist
        */
        if ($this->order) {
            $query .= " {$this->order}";
        }

        /* 
            Add HAVING if exist
        */
        if ($this->having) {
            $query .= " {$this->having}";
        }

        /* 
            Add LIMIT if exist
        */
        if ($this->limit_i) {
            $query .= " {$this->limit_i}";
        }

        return $query;
    }

    /**
     * Delete query chaine
     *
     * @return mixed
     */
    public function DQuery()
    {

        /* 
            Update inital query chaine
        */
        $query = "DELETE FROM {$this->table} ";

        /* 
            Add WHERE if exist
        */
        if ($this->where) {
            $query .= " WHERE {$this->where} ";
        }

        /* 
            Add LIKE if exist
        */
        if ($this->like) {
            $query .= " WHERE {$this->like} LIKE ? ";
        }

        /* 
            Add IS NOT NULL OR IS NULL if exist
        */
        if ($this->is) {
            $query .= " {$this->is}";
        }

        /* 
            Add match if exist
        */
        if ($this->match) {
            $query .= " WHERE MATCH ({$this->match}) AGAINST (?)";
        }

        /* 
            Add BETWEEN if exist
        */
        if ($this->between) {
            $query .= " WHERE {$this->between} BETWEEN ? AND ? ";
        }

        /* 
            Add AND if exist
        */
        if ($this->and) {
            $query .= " {$this->and}";
        }

        /* 
            Add OR if exist
        */
        if ($this->or) {
            $query .= "{$this->or}";
        }

        /* 
            Add HAVING if exist
        */
        if ($this->having) {
            $query .= " {$this->having}";
        }

        /* 
            Add LIMIT if exist
        */
        if ($this->limit_i) {
            $query .= " {$this->limit_i}";
        }

        return $query;
    }
}
