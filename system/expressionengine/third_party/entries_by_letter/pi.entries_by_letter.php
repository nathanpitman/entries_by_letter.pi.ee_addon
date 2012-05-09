<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$plugin_info = array(
  'pi_name'         => 'Entries by letter',
  'pi_version'      => '1.0',
  'pi_author'       => 'Nine Four',
  'pi_author_url'   => 'http://ninefour.co.uk/labs/',
  'pi_description'  => 'Returns entries by letter',
  'pi_usage'        => Entries_by_letter::usage()
);

class entries_by_letter
{

    public $return_data = "";

    // --------------------------------------------------------------------

    public function __construct()
    {
		$this->EE =& get_instance();

		$letters = strtolower($this->EE->TMPL->fetch_param('letters'));
		$field_id = $this->EE->TMPL->fetch_param('field_id');
		$channel_id = $this->EE->TMPL->fetch_param('channel_id');
		
		if (strlen($letters)>1) {
		
			$letters = str_split($letters,1);
		
		} else {
		
			$letter = $letters;
			unset($letters);
		
		}

		$sql = "SELECT entry_id FROM exp_channel_data WHERE channel_id = '".$channel_id."'";
		if (isset($letters)){
			$i = 0;
			foreach($letters AS $letter) {
				if ($i==0) {
					$sql .= "AND LOWER(".$field_id.") LIKE '".$letter."%'";
				} else {
					$sql .= "OR LOWER(".$field_id.") LIKE '".$letter."%'";
				}
				$i++;
			}	
		} else {
			$sql .= "AND LOWER(".$field_id.") LIKE '".$letter."%'";
		}
		$sql .= "ORDER BY ".$field_id." DESC";
				
		$query = $this->EE->db->query($sql);
		$result = $query->result_array();

		$entry_ids = "";
		foreach($result AS $row) {
			$entry_ids[] .= $row['entry_id'];
		}
		
		// Implode, back to a pipe delimited string
		$entry_ids = implode("|", $entry_ids);
		
		$this->return_data = $entry_ids;
		return $this->return_data;
		
    }
    

    // --------------------------------------------------------------------

    /**
     * Usage
     *
     * This function describes how the plugin is used.
     *
     * @access  public
     * @return  string
     */
    public static function usage()
    {
        ob_start();  ?>

You can use this plug-in to return entry IDs of entries matching on start letter(s):

    {exp:entries_by_letter field_id="field_id_4" channel_id="2" letters="ABCDE"}

You can choose to pass multiple or single letters.

    <?php
        $buffer = ob_get_contents();
        ob_end_clean();

        return $buffer;
    }
    // END
}
/* End of file pi.entries_by_letter.php */
/* Location: ./system/expressionengine/third_party/entries_by_letter/pi.entries_by_letter.php */