<?php
    function create($entity, $table, $pk)
    {
        $dbconn=mysqli_connect("localhost", "root","123456",'information_schema');

        $sql2 = "SELECT * FROM columns where table_name='".$table."' and TABLE_SCHEMA='gko2o' order by ORDINAL_POSITION asc";
        $result2 = mysqli_query($dbconn, $sql2);

        $list   = array();
        while ($row=mysqli_fetch_array($result2)) {
            $tmp = explode('(', $row['COLUMN_TYPE']);
            if($row['COLUMN_KEY']!='PRI'){
                if($tmp[0]=='int'){
                    $list[$row['COLUMN_NAME']] = 'integer';
                }
                elseif($tmp[0]=='varchar'){
                    $list[$row['COLUMN_NAME']] = 'string';
                }
                else{
                    $list[$row['COLUMN_NAME']] = $tmp[0];
                }
            }
        }

        $xml_arr = array(
            'entity'    => $entity,
            'table'     => $table,
            'pk'        => $pk,
            'list'      => $list
        );

        $xml = <<<EOF
<doctrine-mapping xmlns="http://doctrine-project.org/schemas/orm/doctrine-mapping"
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xsi:schemaLocation="http://doctrine-project.org/schemas/orm/doctrine-mapping
                    http://raw.github.com/doctrine/doctrine2/master/doctrine-mapping.xsd">

      <entity name="%s" table="%s">
          <id name="%s" type="integer" column="%s">
              <generator strategy="AUTO" />
          </id>
%s
      </entity>
      
</doctrine-mapping>
EOF;
        $field_tpl  = '          <field name="%s" type="%s" />'."\n";
        $field_str  = '';
        foreach ($xml_arr['list'] as $k => $v) {
            $field_str .= sprintf($field_tpl, $k, $v);
        }
        $xml_val    = sprintf($xml, $xml_arr['entity'], $xml_arr['table'], $xml_arr['pk'], $xml_arr['pk'], $field_str);
        echo $xml_val;




        $php = <<<EOF
<?php
namespace Data\Dao\;

/**
 * %s
 */
class %s
{
    /**
     * @var integer
     */
    private \$id;

    %s

    public function __construct()
    {
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function get_id()
    {
        return \$this->id;
    }

    %s
}

EOF;


        $php_field_tpl  = <<<EOF
    /**
     * @var %s
     */
    private \$%s;
EOF;
        $php_field_str  = '';
        foreach ($xml_arr['list'] as $k => $v) {
            $php_field_str .= sprintf($php_field_tpl, $v, $k);
        }

        $php_func_tpl  = <<<EOF
    /**
     * Set %s
     *
     * @param %s \$%s
     * @return object
     */
    public function set_%s(\$%s)
    {
        \$this->%s = \$%s;

        return \$this;
    }

    /**
     * Get %s
     *
     * @return %s 
     */
    public function get_%s()
    {
        return \$this->%s;
    }
EOF;
        $php_func_str  = '';
        foreach ($xml_arr['list'] as $k => $v) {
            $php_func_str .= sprintf($php_func_tpl, $k, $v, $k, $k, $k, $k, $k);
        }


        $php_contents = sprintf($php, $entity, ucfirst($table), ucfirst($table),  $php_field_str, $php_func_str);


        echo "\n\n";
        echo $php_contents;
    }

    create('Data\Dao\Bu','bu','id');







