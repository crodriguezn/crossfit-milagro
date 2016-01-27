<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Business_App_Catalog
{
    static public function listByType($catalog_type_mix)
    {
        $oBus = new Response_Business();

        $MY = & MY_Controller::get_instance();

        /* @var $mCatalog Catalog_Model  */
        $mCatalog =& $MY->mCatalog;
        
        $data = array();
        
        try
        {
            if( is_array($catalog_type_mix) )
            {
                foreach( $catalog_type_mix as $idx => $value )
                {
                    $eCatalogos = $mCatalog->listByType($value);
                    
                    $eCatalogos = Helper_Array::entitiesToIdText($eCatalogos, 'code', 'name', 'value', 'text');

                    $data[ $value ] = $eCatalogos;
                }

            }
            else
            {
                $eCatalogos = $mCatalog->listByType($catalog_type_mix);
                
                $eCatalogos = Helper_Array::entitiesToIdText($eCatalogos, 'code', 'name', 'value', 'text');
                
                $data[ $catalog_type_mix ] = $eCatalogos;
            }
            
            $oBus->isSuccess(TRUE);
        }
        catch( Exception $e )
        {
            $oBus->isSuccess(FALSE);
            $oBus->message( $e->getMessage() );
        }
        
        
        $oBus->data( array( 'eCatalogs' => $data ) );
        
        return $oBus;
    }
    
    /*static public function loadCatalog()
    {
        $oBus = new Response_Business();

        $MY = & MY_Controller::get_instance();
        $MY->load->model('catalog_model', 'mCatalog');

        /* @var $mCatalog Catalog_Model  */
        /*$mCatalog = $MY->mCatalog;

        $generoCatalog    = $mCatalog->listByType('GENDER');
        $tipoIdentCatalog = $mCatalog->listByType('TIPO_IDENT');

        $oBus->isSuccess(TRUE);
        $oBus->data(array(
            'generoCatalog' => $generoCatalog,
            'tipoIdentCatalog' => $tipoIdentCatalog
        ));

        return $oBus;
    }*/

    static public function listCatalog()
    {
        $oBus = new Response_Business();
        
        $MY =& MY_Controller::get_instance();
        
        /* @var $mCatalog Catalog_Model  */
        $mCatalog = $MY->mCatalog;
        
        /* @var $mCatalogByType Catalog_Type_Model  */
        $mCatalogByType = $MY->mCatalogType;
        
        $data = array();
        
        $mCatalogByTypes = $mCatalogByType->listAll(NULL, NULL, NULL);
        
        if( !empty($mCatalogByTypes) )
        {
            
            foreach( $mCatalogByTypes as $eTypeByCatalog )
            {
                /* @var $eTypeByCatalog eCatalogType */
                $eCatalogos = $mCatalog->listAll( $eTypeByCatalog->id, NULL, NULL);
                
                $data[] = array(
                    'eTypeByCatalog'   => $eTypeByCatalog, 
                    'eCatalog' => $eCatalogos 
                );
            }
        }
        
        $oBus->isSuccess(TRUE);
        $oBus->data($data);
               
        return $oBus;
    }
}
