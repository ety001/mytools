<?php
    function create($entity, $table, $pk)
    {
        $sss = explode('_', $table);
        foreach ($sss as $k => $v) {
            $sss[$k]    = ucfirst($v);
        }
        $sss = implode('.', $sss);
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
        file_put_contents('xml/Data.Dao.'.$sss.'.dcm.xml', $xml_val);
    }

    create('Data\Dao\Payment','payment','id');







