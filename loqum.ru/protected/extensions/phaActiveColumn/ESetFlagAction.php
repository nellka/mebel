<?php
/**
 * ESetFlagAction class file.
 *
 * @author Lev
 */

/**
 * ESetFlagAction represents an action that sets a model's flag according to a user-specified parameter.
 * --- TODO UPDATE DESCRIPTION
 * By default, the view being displayed is specified via the <code>view</code> GET parameter.
 * The name of the GET parameter can be customized via {@link viewParam}.
 * If the user doesn't provide the GET parameter, the default view specified by {@link defaultView}
 * will be displayed.
 *
 * Users specify a view in the format of <code>path.to.view</code>, which translates to the view name
 * <code>BasePath/path/to/view</code> where <code>BasePath</code> is given by {@link basePath}.
 *
 * Note, the user specified view can only contain word characters, dots and dashes and
 * the first letter must be a word letter.
 *
 * @property string $requestedView The name of the view requested by the user.
 * This is in the format of 'path.to.view'.
 *
 * @author Lev
 */
class ESetFlagAction extends CAction
{
    /**
     * @var string the name of the GET parameter that contains the requested view name. Defaults to 'view'.
     */
    public $modelClassName='Page';
    /**
     * @var string fieldName to update
     */
    public $fieldName='status';
    /**
     * @var bool save only attribute without saving full model
     * When false using (@link Model::save) method
     */
    public $saveAttribute = false;
    /**
     * @var string url fo redirect after action
     * When false, nothing return
     * When null - using Referer
     */
    public $redirectUrl=null;

    /**
     * Runs the action.
     * This method displays the view requested by the user.
     * @throws CHttpException if model is invalid
     */
    public function run()
    {
        $modelClassName = $this->modelClassName;
        $fieldName = $this->fieldName;
        if (!$model = CActiveRecord::model($modelClassName)->findByPk(Yii::app()->request->getPost('item')))
            throw new CHttpException('404','Model not found');

        $model->{$fieldName} = Yii::app()->request->getPost('checked')==1?1:0;

        if ($this->saveAttribute)
            $model->saveAttributes(array($this->fieldName));
        else
            $model->save();
        print_r ($model->getErrors());

        if ($this->redirectUrl===null)
            $this->redirectUrl = Yii::app()->request->getUrlReferrer();
        if ($this->redirectUrl)
            $this->controller->redirect($this->redirectUrl);

    }

    /**
     * Raised right before the action invokes the render method.
     * Event handlers can set the {@link CEvent::handled} property
     * to be true to stop further view rendering.
     * @param CEvent $event event parameter
     */
    public function onBeforeRender($event)
    {
        $this->raiseEvent('onBeforeRender',$event);
    }

    /**
     * Raised right after the action invokes the render method.
     * @param CEvent $event event parameter
     */
    public function onAfterRender($event)
    {
        $this->raiseEvent('onAfterRender',$event);
    }
}